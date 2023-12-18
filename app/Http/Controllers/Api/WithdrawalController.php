<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WithdrawalResource;
use App\Models\Settings;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\WalletLogs;
use App\Models\Withdrawals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class WithdrawalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $withdrawals = Withdrawals::where('requested_by_user', $user->id)->get();
        return WithdrawalResource::collection($withdrawals);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->withdrawal_action == User::DISABLE_WITHDRAWAL)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'User cannot withdraw'
            ]);
        }

        if ($user->kyc_approval_status != User::KYC_STATUS_VERIFIED)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Pending KYC'
            ]);
        }

        if ($user->user_wallet->wallet_status == UserWallet::STATUS_INACTIVE)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'User Wallet not active'
            ]);
        }

        if (Withdrawals::where('requested_by_user', $user->id)->where('status', Withdrawals::STATUS_PENDING)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'User have pending withdrawal request'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'withdrawal_pin' => [
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->withdrawal_pin)) {
                        $fail('The Withdrawal Pin is invalid');
                    }
                },
                'required'
            ],
        ])->setAttributeNames([
            'amount' => 'Amount',
            'withdrawal_pin' => 'Withdrawal Pin',
        ]);

        if (!$validator->passes()){
            return response()->json([
                'status' => 'fail',
                'error' => $validator->errors()->toArray()
            ]);
        } else {

            if ($request->amount > $user->wallet_balance)
            {
                return response()->json([
                    'status' => 'fail',
                    'message' => trans('Insufficient Amount')
                ]);
            }

            $settings = Settings::getKeyValue();
            $amount = round($request->amount, 2);
            $fee = $settings['withdrawal_transaction_fee'];
            $amount = $amount - $fee;
            $old_amount = $user->wallet_balance;

            Withdrawals::create([
                'network' => $user->user_wallet->wallet_type,
                'amount' => $amount,
                'address' => $user->user_wallet->wallet_address,
                'transaction_fee' => $fee,
                'status' => Withdrawals::STATUS_PENDING,
                'requested_by_user' => $user->id,
            ]);

            $user->update([
                'wallet_balance' => $old_amount - $amount - $fee
            ]);

            WalletLogs::create([
                'old_balance' => $old_amount,
                'new_balance' => $user->wallet_balance,
                'type' => 'withdraw',
                'amount' => $amount + $fee,
                'remark' => 'Withdrawal Request',
                'user_id' => $user->id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully submitted withdrawal request',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Withdrawals $withdrawal)
    {
        return new WithdrawalResource($withdrawal);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Withdrawals $withdrawal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Withdrawals $withdrawal)
    {
        $user = Auth::user();

        if ($user->withdrawal_action == User::DISABLE_WITHDRAWAL) {
            return response()->json([
                'status' => 'error',
                'message' => 'User cannot withdraw'
            ]);
        }

        if ($user->kyc_approval_status != User::KYC_STATUS_VERIFIED) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pending KYC'
            ]);
        }

        if ($user->user_wallet->wallet_status == UserWallet::STATUS_INACTIVE) {
            return response()->json([
                'status' => 'error',
                'message' => 'User Wallet not active'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'withdrawal_pin' => [
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->withdrawal_pin)) {
                        $fail(trans('public.withdrawal_pin_invalid'));
                    }
                },
                'required'
            ],
        ])->setAttributeNames([
            'amount' => 'Amount',
            'withdrawal_pin' => 'Withdrawal Pin',
        ]);

        if (!$validator->passes()){
            return response()->json([
                'status' => 'fail',
                'error' => $validator->errors()->toArray()
            ]);
        } else {

            if ($request->amount > $user->wallet_balance)
            {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Insufficient Amount'
                ]);
            }

            $settings = Settings::getKeyValue();
            $amount = round($request->amount, 2);
            $fee = $settings['withdrawal_transaction_fee'];
            $amount = $amount - $fee;
            $old_wallet_balance = $user->wallet_balance;
            $old_amount = $withdrawal->amount + $fee;

            $withdrawal->update([
                'amount' => $amount,
            ]);

            $user->update([
                'wallet_balance' => ($old_amount + $old_wallet_balance) - ($amount + $fee)
            ]);

            WalletLogs::create([
                'old_balance' => $old_wallet_balance,
                'new_balance' => $user->wallet_balance,
                'type' => 'withdraw',
                'amount' => $amount + $fee,
                'remark' => 'Edit Withdrawal Request Amount',
                'user_id' => $user->id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully Updated Withdrawal Request',
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Withdrawals $withdrawals)
    {
        //
    }

    public function withdrawal_cancel(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $withdrawal = Withdrawals::find($id);
        $user = Auth::user();

        if (!$withdrawal) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Invalid Action',
            ]);
        }

        $settings = Settings::getKeyValue();
        $fee = $settings['withdrawal_transaction_fee'];
        $old_wallet_balance = $user->wallet_balance;
        $old_amount = $withdrawal->amount + $fee;

        $withdrawal->update([
            'status' => Withdrawals::STATUS_CANCELLED
        ]);

        $user->update([
            'wallet_balance' => ($old_amount + $old_wallet_balance)
        ]);

        WalletLogs::create([
            'old_balance' => $old_wallet_balance,
            'new_balance' => $user->wallet_balance,
            'type' => 'withdraw',
            'amount' => 0.00,
            'remark' => 'Cancel Withdrawal Request',
            'user_id' => $user->id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully Cancelled Withdrawal Request',
        ]);
    }
}
