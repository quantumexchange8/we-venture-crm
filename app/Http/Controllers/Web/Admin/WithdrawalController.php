<?php

namespace App\Http\Controllers\Web\Admin;

use App\Exports\ExportWithdrawal;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWithdrawalRequest;
use App\Imports\WithdrawalImport;
use App\Models\ActionLogs;
use App\Models\Brokers;
use App\Models\SettingCountry;
use App\Models\User;
use App\Models\WalletLogs;
use App\Models\Withdrawals;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Alert;
use Session;

class WithdrawalController extends Controller
{
    public function approval(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in(['approve', 'reject'])],
        ]);
        $approval = $request->input('status');
        $withdrawal = Withdrawals::find($id);
        $user = $withdrawal->user;
        $old_wallet_balance = $user->wallet_balance;

        $total_withdraw_amount = $withdrawal->amount + $withdrawal->transaction_fee;

        if ($withdrawal->status != Withdrawals::STATUS_PENDING) {
            Alert::error(trans('public.invalid_action'), trans('public.try_again'));
            return back();
        }

        switch ($approval) {
            case 'approve':
                $withdrawal->update([
                    'status' => Withdrawals::STATUS_APPROVED,
                ]);

                WalletLogs::create([
                    'old_balance' => $old_wallet_balance,
                    'new_balance' => $user->wallet_balance,
                    'type' => 'withdraw',
                    'amount' => $total_withdraw_amount,
                    'remark' => 'Withdrawal Request Approved',
                    'user_id' => $user->id,
                ]);

                ActionLogs::create([
                    'user_id' => Auth::id(),
                    'type' => Withdrawals::class,
                    'description' => 'Admin with id: ' . Auth::id() . ' has APPROVED Withdrawal Request with id: ' . $withdrawal->id,
                ]);

                break;

            case 'reject':
                $withdrawal->update([
                    'status' => Withdrawals::STATUS_REJECTED,
                ]);

                $user->update([
                    'wallet_balance' => ($total_withdraw_amount + $old_wallet_balance)
                ]);

                WalletLogs::create([
                    'old_balance' => $old_wallet_balance,
                    'new_balance' => $user->wallet_balance,
                    'type' => 'withdraw',
                    'amount' => $total_withdraw_amount,
                    'remark' => 'Withdrawal Request Rejected',
                    'user_id' => $user->id,
                ]);

                ActionLogs::create([
                    'user_id' => Auth::id(),
                    'type' => Withdrawals::class,
                    'description' => 'Admin with id: ' . Auth::id() . ' has REJECTED Withdrawal Request with id: ' . $withdrawal->id,
                ]);
                break;
        }

        Alert::success(trans('public.done'), trans('public.successfully_updated_withdrawal_status'));
        return back();
    }

    public function listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['report_withdrawal' => [
                        'freetext' =>  $request->input('freetext'),
                        'created_start' => $request->input('created_start'),
                        'created_end' => $request->input('created_end'),
                        'status' => $request->input('status'),
                        'country' => $request->input('country')
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportWithdrawal( Withdrawals::get_record(session('report_withdrawal'))), $now . '-withdrawal-records.xlsx');
                case 'reset':
                    session()->forget('report_withdrawal');
                    break;
            }
        }

        $search = session('report_withdrawal') ? session('report_withdrawal') : $search;

        return view('admin.report.withdrawal', [
            'title' => 'Withdrawals',
            'submit' => route('report_withdrawal'),
            'records' => Withdrawals::get_record($search)->paginate(10),
            'search' =>  $search,
            'brokers' => Brokers::all(),
            'get_status_sel' => ['' => trans('public.select_status')] + [1 => trans('public.process'), 2 => trans('public.approved'), 3 => trans('public.rejected'), 4 => trans('public.cancelled')],
            'get_country_sel' => SettingCountry::get_country_sel(app()->getLocale()),
        ]);
    }

    public function listingChildren(Request $request)
    {

        $users = User::query()
            ->where('status', 1)
            ->where('role', 1)
            ->where('deleted_at', null)
            ->where('name','LIKE','%'.$request->keyword.'%')
            ->get();
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['report_withdrawal_children' => [
                        'user_id' =>  $request->input('user_id'),
                        'created_start' => $request->input('created_start'),
                        'created_end' => $request->input('created_end'),
                        'status' => $request->input('status'),
                        'type' => 'children',
                        'country' => $request->input('country')
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportWithdrawal(Withdrawals::get_record( session('report_withdrawal_children'))), $now . '-withdrawal-records.xlsx');
                case 'reset':
                    session()->forget('report_withdrawal_children');
                    break;
            }
        }

        $search = session('report_withdrawal_children') ? session('report_withdrawal_children') : $search;

        return view('admin.report.withdrawal-children', [
            'title' => 'Withdrawals - Downline',
            'submit' => route('report_withdrawal_children'),
            'records' => Withdrawals::get_record($search)->paginate(10),
            'search' =>  $search,
            'users' => $users,
            'brokers' => Brokers::all(),
            'get_status_sel' => ['' => trans('public.select_status')] + [1 => trans('public.process'), 2 => trans('public.approved'), 3 => trans('public.rejected'), 4 => trans('public.cancelled')],
            'get_country_sel' => SettingCountry::get_country_sel(app()->getLocale()),
        ]);
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'import':
                    $request->validate(
                        [
                            'file' => 'required|mimes:xlsx, csv, xls',
                        ], [
                            'file.required' => trans('public.file_required'),
                            'file.mimes' => trans('public.file_mimes'),
                        ]
                    );
                    $import = new WithdrawalImport();
                    $import->import($request->file('file'));
                    $errorMsg = [];
                    if (count($import->failures()) > 0) {
                        foreach ($import->failures() as $failure) {
                            $tempMsg = trans('public.import_error', ['row' => $failure->row()]) . $failure->errors()[0];
                            array_push($errorMsg, $tempMsg);
                        }
                        return back()->withErrors($errorMsg);
                    }
                    break;
                case 'download':
                    $filePath = public_path('WeVenture_Withdrawal_Import_Template.xlsx');
                    return response()->download($filePath);
            }
        }

        Alert::success(trans('public.done'), trans('public.import_success'));
        return redirect()->back();
    }
}
