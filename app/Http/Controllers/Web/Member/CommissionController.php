<?php

namespace App\Http\Controllers\Web\Member;

use App\Exports\ExportBonusHistories;
use App\Exports\ExportCommissions;
use App\Exports\WorldPoolHistoryExport;
use App\Http\Controllers\Controller;
use App\Models\BonusHistories;
use App\Models\Brokers;
use App\Models\Commissions;
use App\Models\Deposits;
use App\Models\WorldPoolHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CommissionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $userIds = [$user->id];
        $search = array();

        if ($request->isMethod('post')) {

            $submit_type = $request->input('submit');
            switch ($submit_type) {
                case 'search':

                    session(['commissions_self_search' => [
                        'filter_broker' =>  $request->input('filter_broker'),
                        'transaction_start' => $request->input('transaction_start'),
                        'transaction_end' => $request->input('transaction_end'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportCommissions(Commissions::get_commissions_table(session('commissions_self_search') , $user->id), true), $now . '-commissions-records.xlsx');
                case 'reset':
                    session()->forget('commissions_self_search');
                    break;
            }
        }

        $search = session('commissions_self_search') ? session('commissions_self_search') : $search;

        return view('member/commissions', [
            'submit' => route('commissions_listing'),
            'commissions' => Commissions::get_commissions_table($search, $user->id)->paginate(10),
            'brokers' => Brokers::all(),
            'personal_total' => $user->personalCommissions(),
            'search' =>  $search,
        ]);
    }

    public function network(Request $request)
    {

        $user = Auth::user();
        $userIds = $user->getChildrenIds();

        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');
            switch ($submit_type) {
                case 'search':

                    session(['commissions_network_search' => [
                        'filter_broker' =>  $request->input('filter_broker'),
                        'transaction_start' => $request->input('transaction_start'),
                        'transaction_end' => $request->input('transaction_end'),
                        'freetext' =>  $request->input('freetext'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportBonusHistories(BonusHistories::get_commissions_table(session('commissions_network_search'), $user->id)), $now . '-commissions-records.xlsx');
                case 'reset':
                    session()->forget('commissions_network_search');
                    break;
            }
        }
        $group_total = BonusHistories::where('upline_id', $user->id)->where('deleted_at', '=', null)->sum('bonus_amount');

        $search = session('commissions_network_search') ? session('commissions_network_search') : $search;
        return view('member/network', [
            'submit' => route('network_commissions_listing'),
            'commissions' => BonusHistories::get_commissions_table($search, $user->id)->paginate(10),
            'brokers' => Brokers::all(),
            'group_total' => $group_total,
            'search' =>  $search,
        ]);
    }

    public function lot_size_pool(Request $request)
    {
        $search = array();
        $user = Auth::user();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['lot_size_pool_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'created_start' => $request->input('created_start'),
                        'created_end' => $request->input('created_end'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new WorldPoolHistoryExport( WorldPoolHistory::get_record(session('lot_size_pool_search'), 1)), $now . '-performance-bonus-records.xlsx');

                case 'reset':
                    session()->forget('lot_size_pool_search');
                    break;
            }
        }

        $search = session('lot_size_pool_search') ? session('lot_size_pool_search') : $search;

        return view('member.lot_size_pool', [
            'title' => 'Lot Size Pool',
            'records' => WorldPoolHistory::get_record($search)->paginate(10),
            'search' =>  $search,
        ]);
    }
}
