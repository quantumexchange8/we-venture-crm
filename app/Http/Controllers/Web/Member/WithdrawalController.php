<?php

namespace App\Http\Controllers\Web\Member;

use App\Exports\ExportWithdrawal;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWithdrawalRequest;
use App\Models\Settings;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\WalletLogs;
use App\Models\Withdrawals;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Alert;

class WithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = array();
        $settings = Settings::getKeyValue();
        $wallet_address = UserWallet::where('user_id', $user->id)->where('wallet_status', UserWallet::STATUS_ACTIVE)->first();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');
            switch ($submit_type) {
                case 'search':

                    session(['withdrawal_search' => [
                        'filter_status' =>  $request->input('filter_status'),
                        'created_start' => $request->input('created_start'),
                        'created_end' => $request->input('created_end'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportWithdrawal(Withdrawals::get_withdrawals_table(session('withdrawal_search'), $user->id)), $now . '-withdrawal-records.xlsx');
                case 'reset':
                    session()->forget('withdrawal_search');
                    break;
            }
        }

        $search = session('withdrawal_search') ? session('withdrawal_search') : $search;

        return view('member/withdrawal', [
            'submit' => route('withdrawals_listing'),
            'withdrawals' => Withdrawals::get_withdrawals_table($search, $user->id)->paginate(10),
            'user' => $user,
            'transaction_fee' => $settings['withdrawal_transaction_fee'] ?? 0,
            'search' =>  $search,
            'wallet_address' =>  $wallet_address,
        ]);
    }
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->withdrawal_action == User::DISABLE_WITHDRAWAL)
        {
            Alert::warning(trans('public.invalid_action'), trans('public.try_again'));
            return redirect()->back();
        }

        if ($user->kyc_approval_status != User::KYC_STATUS_VERIFIED)
        {
            Alert::warning(trans('public.invalid_action'), trans('public.try_again'));
            return redirect()->back();
        }

        if ($user->user_wallet->wallet_status == UserWallet::STATUS_INACTIVE)
        {
            Alert::warning(trans('public.invalid_action'), trans('public.try_again'));
            return redirect()->back();
        }

        if (Withdrawals::where('requested_by_user', $user->id)->where('status', Withdrawals::STATUS_PENDING)->exists()) {
            Alert::warning(trans('public.invalid_action'), trans('public.withdrawal_pending_request'));
            return back()->withInput();
        }

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:10',
            'withdrawal_pin' => [
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->withdrawal_pin)) {
                        $fail(trans('public.withdrawal_pin_invalid'));
                    }
                },
            ],
        ])->setAttributeNames([
            'amount' => trans('public.amount'),
            'withdrawal_pin' => trans('public.withdrawal_pin'),
        ]);

        if (!$validator->passes()){
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {

            if ($request->amount > $user->wallet_balance)
            {
                return response()->json([
                    'status' => 2,
                    'msg' => trans('public.insufficient_amount')
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
                'status' => 1,
                'msg' => trans('public.successfully_submit_withdrawal_request'),
            ]);
        }
    }

    public function withdrawal_edit(Request $request)
    {
        $user = Auth::user();
        $withdrawal = Withdrawals::find($request->withdrawal_id);

        if (!$withdrawal)
        {
            Alert::warning(trans('public.invalid_action'), trans('public.try_again'));
            return redirect()->back();
        }

        if ($user->withdrawal_action == User::DISABLE_WITHDRAWAL)
        {
            Alert::warning(trans('public.invalid_action'), trans('public.try_again'));
            return redirect()->back();
        }

        if ($user->kyc_approval_status != User::KYC_STATUS_VERIFIED)
        {
            Alert::warning(trans('public.invalid_action'), trans('public.try_again'));
            return redirect()->back();
        }

        if ($user->user_wallet->wallet_status == UserWallet::STATUS_INACTIVE)
        {
            Alert::warning(trans('public.invalid_action'), trans('public.try_again'));
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:10',
            'withdrawal_pin' => [
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->withdrawal_pin)) {
                        $fail(trans('public.withdrawal_pin_invalid'));
                    }
                },
            ],
        ])->setAttributeNames([
            'amount' => trans('public.amount'),
            'withdrawal_pin' => trans('public.withdrawal_pin'),
        ]);

        if (!$validator->passes()){
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {

            if ($request->amount > $user->wallet_balance)
            {
                return response()->json([
                    'status' => 2,
                    'msg' => trans('public.insufficient_amount')
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
                'status' => 1,
                'msg' => trans('public.successfully_update_withdrawal'),
            ]);
        }
    }

    public function withdrawal_cancel(Request $request)
    {
        $withdrawal_id = $request->input('withdrawal_id');
        $withdrawal = Withdrawals::find($withdrawal_id);
        $user = Auth::user();

        if (!$withdrawal) {
            Alert::error(trans('public.invalid_action'), trans('public.try_again'));
            return redirect()->back();
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

        Alert::success(trans('public.done'), trans('public.successfully_cancel_withdrawal'));
        return redirect()->back();
    }

}
