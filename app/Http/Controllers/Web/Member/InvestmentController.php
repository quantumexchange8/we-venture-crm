<?php

namespace App\Http\Controllers\Web\Member;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\Portfolio;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Alert;
use Maatwebsite\Excel\Facades\Excel;

class InvestmentController extends Controller
{
    public function portfolio(Request $request)
    {
        $portfolios = Portfolio::query()
            ->where('status', '=', 'active')
            ->whereJsonContains('user_ids', Auth::id())
            ->get();

        $settings = Settings::getKeyValue();
        $wallet_address = $settings['cryptocurrency_wallet_address'];

        return view('member.investment.portfolio', [
            'portfolios' => $portfolios,
            'wallet_address' => $wallet_address,
        ]);
    }

    public function choose_plan(Request $request)
    {
        $user = Auth::user();
        $portfolio = Portfolio::find($request->portfolio_id);

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:' . $portfolio->min_amount,
            'deposit_receipt' => 'required|mimes:jpeg,png,pdf'
        ])->setAttributeNames([
            'amount' => trans('public.amount'),
            'deposit_receipt' => trans('public.deposit_receipt'),
        ]);

        if (!$validator->passes()){
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {

            $investment = Investment::create([
                'user_id' => $user->id,
                'portfolio_id' => $request->portfolio_id,
                'deposit_amount' => $request->amount,
                'status' => 'processing',
            ]);

            if ($request->hasFile('deposit_receipt')) {
                $investment->addMedia($request->deposit_receipt)->toMediaCollection('deposit_receipt');
            }

             return response()->json([
                 'status' => 1,
                 'msg' => trans('public.successfully_submitted_deposit_request'),
             ]);
        }
    }

    public function investment_plan(Request $request)
    {
        $user = Auth::user();
        $search = array();
        $settings = Settings::getKeyValue();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');
            switch ($submit_type) {
                case 'search':

                    session(['investment_plan_search' => [
                        'filter_status' =>  $request->input('filter_status'),
                        'created_start' => $request->input('created_start'),
                        'created_end' => $request->input('created_end'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('investment_plan_search');
                    break;
            }
        }

        $search = session('investment_plan_search') ? session('investment_plan_search') : $search;
        $wallet_address = $settings['cryptocurrency_wallet_address'];
        return view('member.investment.investment_plan', [
            'title' => 'Investment Plan',
            'submit' => route('withdrawals_listing'),
            'records' => Investment::get_member_records($search, $user->id)->paginate(10),
            'user' => $user,
            'search' =>  $search,
            'wallet_address' =>  $wallet_address,
        ]);
    }

    public function edit_plan(Request $request)
    {
        $user = Auth::user();
        $portfolio = Portfolio::find($request->portfolio_id);
        $investment = Investment::find($request->investment_id);

        if ($investment->status != 'processing') {
            Alert::error(trans('public.invalid_action'), trans('public.try_again'));
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:' . $portfolio->min_amount,
            'deposit_receipt' => 'required|mimes:jpeg,png,pdf'
        ])->setAttributeNames([
            'amount' => trans('public.amount'),
            'deposit_receipt' => trans('public.deposit_receipt'),
        ]);

        if (!$validator->passes()){
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {

            $investment->update([
                'deposit_amount' => $request->amount,
            ]);

            if ($request->hasFile('deposit_receipt')) {
                $investment->clearMediaCollection('deposit_receipt');
                $investment->addMedia($request->deposit_receipt)->toMediaCollection('deposit_receipt');
            }

            return response()->json([
                'status' => 1,
                'msg' => trans('public.successfully_submitted_deposit_request'),
            ]);
        }
    }
}
