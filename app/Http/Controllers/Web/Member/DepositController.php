<?php

namespace App\Http\Controllers\Web\Member;

use App\Exports\ExportDeposits;
use App\Exports\ExportMonthlyDeposit;
use App\Http\Controllers\Controller;
use App\Imports\DepositsImport;
use App\Models\Brokers;
use App\Models\Deposits;
use App\Models\SettingCountry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class DepositController extends Controller
{

    public function deposit(Request $request, $id)
    {
        $user = User::find($id);

        $search = array();

        if ($request->isMethod('post')) {

            $submit_type = $request->input('submit');
            switch ($submit_type) {
                case 'search':

                    session(['deposit_search' => [
                        'filter_broker' =>  $request->input('filter_broker'),
                        'transaction_start' => $request->input('transaction_start'),
                        'transaction_end' => $request->input('transaction_end'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('deposit_search');
                    break;
            }
        }

        $search = session('deposit_search') ? session('deposit_search') : $search;

        return view("member/deposit", [
            'submit' => route('deposits_listing', $id),
            'deposits' => Deposits::get_deposits_table($search, 10, $user->id),
            'brokers' => Brokers::all(),
            'personal_total' => $user->personalDeposits(),
            'broker_group' =>  $user->personalDepositsByBrokers(),
            'user' => $user,
            'search' =>  $search,
        ]);
    }
    public function index2(Request $request)
    {
        $user = Auth::user();

        $search = array();

        if ($request->isMethod('post')) {

            $submit_type = $request->input('submit');
            switch ($submit_type) {
                case 'search':

                    session(['fund_search' => [
                        'filter_broker' =>  $request->input('filter_broker'),
                        'transaction_start' => $request->input('transaction_start'),
                        'transaction_end' => $request->input('transaction_end'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('fund_search');
                    break;
            }
        }

        $search = session('fund_search') ? session('fund_search') : $search;

        return view('member/funds', [
            'submit' => route('funds_listing'),
            'deposits' => Deposits::get_deposits_table($search, 10, $user->id),
            'brokers' => Brokers::all(),
            'personal_total' => $user->personalDeposits(),
            'broker_group' =>  $user->personalDepositsByBrokers(),
            'search' =>  $search,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'file'          => 'required|mimes:xlsx, csv, xls',
            ]
        );
        $import = new DepositsImport;
        $import->import($request->file('file'));
        $errorMsg = [];
        if(count($import->failures()) > 0) {
            foreach ($import->failures() as $failure) {
                $tempMsg = 'Error on row '.' '.$failure->row().'. '.  $failure->errors()[0];
                array_push($errorMsg, $tempMsg);
            }
            return back()->withErrors($errorMsg);
        }
        return back()->with('success', 'User Imported Successfully.');
    }

    public function export(Request $request)
    {
        $user = Auth::user();
        $now = Carbon::now()->format('YmdHis');
        $userIds = [$user->id];
        if ($request->underline) {
            $userIds= $user->getChildrenIds();
        }
        return Excel::download(new ExportDeposits($userIds), $now.'-deposits-records.xlsx');
    }

    public function dailyMonthlyDownlineListing(Request $request)
    {
        $user = Auth::user();
        $users = User::query()->where('hierarchyList', 'like', '%-' . $user->id . '-%')->orwhere('id', $user->id)
            ->where('status', User::STATUS_ACTIVE)->get();

        $month = [];
        $year = [];

        for ($m=1; $m<=12; $m++) {
            $month[$m] = date('F', mktime(0,0,0,$m, 1, date('Y')));
        }
        foreach (range(Carbon::now()->year, 2022) as $yr) {
            $year[$yr] = $yr;
        }
        $current = Carbon::now();
        $search =   session('daily_monthly_deposits_children_search') ? session('daily_monthly_deposits_children_search') :session(['daily_monthly_deposits_children_search' => [
            'filter_type' => 'daily',
            'filter_year' => Carbon::now()->year,
            'filter_month' =>  $current->copy()->month,
        ]]);


        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['daily_monthly_deposits_children_search' => [
                        'user_id' =>  $request->input('user_id'),
                        'transaction_start' => $request->input('transaction_start'),
                        'transaction_end' => $request->input('transaction_end'),
                        'filter_type' => $request->input('filter_type'),
                        'filter_year' => $request->input('filter_year'),
                        'filter_month' => $request->input('filter_month'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');

                    return Excel::download(new ExportMonthlyDeposit( Deposits::get_member_daily_monthly_table(session('daily_monthly_deposits_children_search'), $user)), $now . '-deposits-downline-daily-monthly-records.xlsx');

                case 'reset':
                    session()->forget('daily_monthly_deposits_children_search');
                    session(['daily_monthly_deposits_children_search' => [
                        'filter_type' => 'daily',
                        'filter_year' => $current->copy()->year,
                        'filter_month' =>  $current->copy()->month,
                    ]]);
                    break;
            }
        }

        $search = session('daily_monthly_deposits_children_search') ? session('daily_monthly_deposits_children_search') : $search;
        $query = Deposits::get_member_daily_monthly_table($search, $user);

        $perPage = 10; // Number of records to display per page

        $records = $query->get();

        // Manually slice the records based on the current page
        $current_page = request()->input('page', 1);
        $sliced = $records->slice(($current_page - 1) * $perPage, $perPage);

        $paginator = new LengthAwarePaginator(
            $sliced,
            $records->count(),
            $perPage,
            $current_page,
            ['path' => url()->current()]
        );

        return view('member/deposits_daily_monthly', [
            'title' => 'Deposits - Downline',
            'submit' => route('daily_monthly_deposits_listing'),
            'records' => $paginator,
            'search' => $search,
            'user' => $user,
            'users' => $users,
            'get_filter_month' => $month,
            'get_filter_year' => $year,
            'total' => $records->sum('dep_amount') - $records->sum('with_total')
        ]);
    }
}
