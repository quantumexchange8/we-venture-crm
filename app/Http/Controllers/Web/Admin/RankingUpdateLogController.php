<?php

namespace App\Http\Controllers\Web\Admin;

use App\Exports\ExportCommissions;
use App\Http\Controllers\Controller;
use App\Models\Brokers;
use App\Models\Commissions;
use App\Models\RankUpdateLogs;
use App\Models\SettingCountry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RankingUpdateLogController extends Controller
{
    public function listing(Request $request)
    {
        $month = [];
        $year = [];

        for ($m=1; $m<=12; $m++) {
            $month[$m] = date('F', mktime(0,0,0,$m, 1, date('Y')));
        }
        foreach (range(Carbon::now()->year, 2022) as $yr) {
            $year[$yr] = $yr;
        }
        $current = Carbon::now();

        $search =   session('admin_rank_log_search') ? session('admin_rank_log_search') :session(['admin_rank_log_search' => [
            'transaction_start' => $current->copy()->startOfMonth()->format('Y-m-d H:i:s'),
            'transaction_end' =>  $current->copy()->endOfMonth()->format('Y-m-d H:i:s'),
        ]]);

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    $start_date = Carbon::createFromDate($request->input('filter_year'), $request->input('filter_month'))->startOfMonth()->format('Y-m-d H:i:s');
                    $end_date = Carbon::createFromDate($request->input('filter_year'), $request->input('filter_month'))->endOfMonth()->format('Y-m-d H:i:s');
                    session(['admin_rank_log_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'transaction_start' => $start_date,
                        'transaction_end' => $end_date,
                        'filter_year' => $request->input('filter_year'),
                        'filter_month' => $request->input('filter_month'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportCommissions(Commissions::get_record( session('admin_rank_log_search'))), $now . '-commissions-records.xlsx');
                case 'reset':
                    session()->forget('admin_rank_log_search');
                    session(['admin_rank_log_search' => [
                        'filter_year' => $current->copy()->year,
                        'filter_month' =>  $current->copy()->month,
                        'transaction_start' => $current->copy()->startOfMonth()->format('Y-m-d H:i:s'),
                        'transaction_end' =>  $current->copy()->endOfMonth()->format('Y-m-d H:i:s'),
                    ]]);
                    break;
            }
        }

        $search = session('admin_rank_log_search') ? session('admin_rank_log_search') : $search;

        return view('admin.report.rank_update', [
            'title' => 'Lot Size',
            'records' => RankUpdateLogs::get_record($search)->paginate(10),
            'search' =>  $search,
            'get_filter_month' => $month,
            'get_filter_year' => $year,
        ]);
    }
}
