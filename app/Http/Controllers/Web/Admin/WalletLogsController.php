<?php

namespace App\Http\Controllers\Web\Admin;

use App\Exports\ExportDeposits;
use App\Exports\ExportWalletLogs;
use App\Http\Controllers\Controller;
use App\Models\Brokers;
use App\Models\Deposits;
use App\Models\SettingCountry;
use App\Models\WalletLogs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class WalletLogsController extends Controller
{
    public function listing(Request $request)
    {
        $search = array();


        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['admin_wallet_logs_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'transaction_start' => $request->input('created_start'),
                        'transaction_end' => $request->input('created_end'),
                        'type' => $request->input('type'),
                    ]]);
                    break;

                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportWalletLogs( WalletLogs::get_report_record(session('admin_wallet_logs_search'))), $now . '-wallet-logs-records.xlsx');

                case 'reset':
                    session()->forget('admin_wallet_logs_search');
                    break;
            }
        }

        $search = session('admin_wallet_logs_search') ? session('admin_wallet_logs_search') : $search;

        return view('admin.report.wallet_logs', [
            'title' => 'Wallet Logs',
            'submit' => route('wallet_logs_listing'),
            'records' => WalletLogs::get_report_record($search)->paginate(10),
            'search' =>  $search,
            'get_type_sel' =>  ['commissions' => trans('public.commissions'), 'network' => trans('public.network'), 'performance_bonus' => trans('public.performance_bonus'), 'extra_bonus' => trans('public.extra_bonus'), 'withdraw' => trans('public.withdraw'), 'wallet_adjustment' => trans('public.wallet_adjustment')],
        ]);
    }
}
