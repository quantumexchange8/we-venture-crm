<?php

namespace App\Http\Controllers\Web\Admin;

use App\Exports\BonusHistorySummaryExport;
use App\Exports\ExportBonusHistories;
use App\Http\Controllers\Controller;
use App\Models\BonusHistories;
use App\Models\Brokers;
use App\Models\SettingCountry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BonusHistoryController extends Controller
{
    public function listing(Request $request)
    {
        $search = array();

        $users = User::query()
            ->where('status', 1)
            ->where('role', 1)
            ->where('deleted_at', null)
            ->where('name','LIKE','%'.$request->keyword.'%')
            ->get();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['admin_bonus_history_search' => [
                        'user_id' =>  $request->input('user_id'),
                        'freetext' =>  $request->input('freetext'),
                        'type' => 'children',
                        'transaction_start' => $request->input('transaction_start'),
                        'transaction_end' => $request->input('transaction_end'),
                        'bonushistory_type' => $request->input('bonushistory_type'),
                    ]]);

                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportBonusHistories(BonusHistories::get_record( session('admin_bonus_history_search'))), $now . '-bonus-histories-records.xlsx');
                case 'reset':
                    session()->forget('admin_bonus_history_search');
                    break;
            }
        }

        $search = session('admin_bonus_history_search') ? session('admin_bonus_history_search') : $search;
        $query = BonusHistories::get_record($search);

        return view('admin.report.bonus_history_list', [
            'title' => trans('public.network'),
            'records' => BonusHistories::get_record($search)->paginate(10),
            'search' =>  $search,
            'users' => $users,
            'brokers' => Brokers::all(),
            'total_amount' => $query->get()->sum('bonus_amount'),
            'get_type_sel' =>  ['personal' => trans('public.personal'), 'network' => trans('public.network'), 'extra_bonus' => trans('public.extra_bonus')],
        ]);
    }

    public function summary(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['bonus_history_summary_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'transaction_start' => $request->input('transaction_start'),
                        'transaction_end' => $request->input('transaction_end'),
                        'bonushistory_type' => $request->input('bonushistory_type'),
                    ]]);

                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new BonusHistorySummaryExport(BonusHistories::get_summary_record(session('bonus_history_summary_search'))), $now . '-bonus-histories-summary.xlsx');
                case 'reset':
                    session()->forget('bonus_history_summary_search');
                    break;
            }
        }

        $search = session('bonus_history_summary_search') ? session('bonus_history_summary_search') : $search;
        $query = BonusHistories::get_record($search);

        return view('admin.report.bonus_history_summary', [
            'title' => trans('public.network_summary'),
            'records' => BonusHistories::get_summary_record($search)->paginate(10),
            'search' =>  $search,
            'brokers' => Brokers::all(),
            'get_type_sel' =>  ['extra_bonus' => trans('public.extra_bonus'), 'network' => trans('public.network')],
        ]);
    }
}
