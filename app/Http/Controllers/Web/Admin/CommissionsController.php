<?php

namespace App\Http\Controllers\Web\Admin;

use App\Exports\ExportCommissions;
use App\Exports\ExportUser;
use App\Http\Controllers\Controller;
use App\Imports\CommissionsImport;
use App\Models\ActionLogs;
use App\Models\Announcements;
use App\Models\Brokers;
use App\Models\Commissions;
use App\Models\Pamm;
use App\Models\SettingCountry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Alert;
use Session;

class CommissionsController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'import':
                    $request->validate(
                        [
                            'file' => 'required|mimes:xlsx, csv, xls',
                            'broker_id' => ['required', Rule::in(Brokers::pluck('id')->toArray())],
                            'pamm_id' => ['required', Rule::in(Pamm::pluck('id')->toArray())],
                        ], [
                            'file.required' => trans('public.file_required'),
                            'file.mimes' => trans('public.file_mimes'),

                            'broker_id' => trans('public.broker_id'),
                            'pamm_id' => trans('public.pamm_id'),
                        ]
                    );
                    $import = new CommissionsImport($request->input('broker_id'), $request->input('pamm_id'));
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
                    $filePath = public_path('WeVenture_Commissions_Import_Template.xlsx');
                    return response()->download($filePath);
            }
        }

        ActionLogs::create([
            'user_id' => $user->id,
            'type' => Commissions::class,
            'description' => $user->name. ' with id: ' . $user->id . ' has imported commission records',
        ]);

        Alert::success(trans('public.done'), trans('public.import_success'));
        return redirect()->back()->with('success', 'User Imported Successfully.');
    }

    public function listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['admin_commissions_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'transaction_start' => $request->input('transaction_start'),
                        'transaction_end' => $request->input('transaction_end'),
                        'country' => $request->input('country'),
                        'pamm_id' => $request->input('pamm_id'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportCommissions(Commissions::get_record( session('admin_commissions_search'))), $now . '-commissions-records.xlsx');
                case 'reset':
                    session()->forget('admin_commissions_search');
                    break;
            }
        }

        $search = session('admin_commissions_search') ? session('admin_commissions_search') : $search;

        return view('admin.report.commission', [
            'title' => 'Commissions',
            'submit' => route('member_listing'),
            'records' => Commissions::get_record($search)->paginate(10),
            'search' =>  $search,
            'brokers' => Brokers::all(),
            'get_pamm_sel' => Pamm::get_pamm_sel(),
            'get_country_sel' => SettingCountry::get_country_sel(app()->getLocale()),
        ]);
    }

    public function listingLotSize(Request $request)
    {
        $search = array();
        $month = [];
        $year = [];

        for ($m=1; $m<=12; $m++) {
            $month[$m] = date('F', mktime(0,0,0,$m, 1, date('Y')));
        }
        foreach (range(Carbon::now()->year, 2022) as $yr) {
            $year[$yr] = $yr;
        }
        $current = Carbon::now();

        $search =   session('admin_lot_search') ? session('admin_lot_search') :session(['admin_lot_search' => [
            'transaction_start' => $current->copy()->startOfMonth()->format('Y-m-d H:i:s'),
            'transaction_end' =>  $current->copy()->endOfMonth()->format('Y-m-d H:i:s'),
        ]]);

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    $start_date = Carbon::createFromDate($request->input('filter_year'), $request->input('filter_month'))->startOfMonth()->format('Y-m-d H:i:s');
                    $end_date = Carbon::createFromDate($request->input('filter_year'), $request->input('filter_month'))->endOfMonth()->format('Y-m-d H:i:s');
                    session(['admin_lot_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'transaction_start' => $start_date,
                        'transaction_end' => $end_date,
                        'country' => $request->input('country'),
                        'filter_year' => $request->input('filter_year'),
                        'filter_month' => $request->input('filter_month'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportCommissions(Commissions::get_record( session('admin_lot_search'))), $now . '-commissions-records.xlsx');
                case 'reset':
                    session()->forget('admin_lot_search');
                    session(['admin_lot_search' => [
                        'filter_year' => $current->copy()->year,
                        'filter_month' =>  $current->copy()->month,
                        'transaction_start' => $current->copy()->startOfMonth()->format('Y-m-d H:i:s'),
                        'transaction_end' =>  $current->copy()->endOfMonth()->format('Y-m-d H:i:s'),
                    ]]);
                    break;
            }
        }

        $search = session('admin_lot_search') ? session('admin_lot_search') : $search;

        return view('admin.report.commission_lot', [
            'title' => 'Lot Size',
            'records' => Commissions::get_record($search)->paginate(10),
            'search' =>  $search,
            'brokers' => Brokers::all(),
            'get_country_sel' => SettingCountry::get_country_sel(app()->getLocale()),
            'get_filter_month' => $month,
            'get_filter_year' => $year,
        ]);
    }

    public function lot_size_downline_listing(Request $request)
    {
        $search = [];

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
                    session(['admin_lot_children_search' => [
                        'user_id' =>  $request->input('user_id'),
                        'freetext' =>  $request->input('freetext'),
                        'type' => 'children',
                        'transaction_start' => $request->input('transaction_start'),
                        'transaction_end' => $request->input('transaction_end'),
                        'country' => $request->input('country'),
                    ]]);

                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportCommissions(Commissions::get_record( session('admin_lot_children_search'))), $now . '-lot-size-group-records.xlsx');
                case 'reset':
                    session()->forget('admin_lot_children_search');
                    break;
            }
        }

        $search = session('admin_lot_children_search') ? session('admin_lot_children_search') : $search;
        $query = Commissions::get_record($search);

        return view('admin.report.commission_lot-children', [
            'title' => 'Lot Size',
            'records' => Commissions::get_record($search)->paginate(10),
            'search' =>  $search,
            'brokers' => Brokers::all(),
            'get_country_sel' => SettingCountry::get_country_sel(app()->getLocale()),
            'users' => $users,
            'total_amount' => $query->get()->sum('lot_size')
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
                    session(['admin_commissions_children_search' => [
                        'user_id' =>  $request->input('user_id'),
                        'transaction_start' => $request->input('transaction_start'),
                        'transaction_end' => $request->input('transaction_end'),
                        'type' => 'children',
                        'country' => $request->input('country'),
                        'pamm_id' => $request->input('pamm_id'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportCommissions(Commissions::get_record(session('admin_commissions_children_search'))), $now . '-commissions-records.xlsx');
                case 'reset':
                    session()->forget('admin_commissions_children_search');
                    break;
            }
        }

        $search = session('admin_commissions_children_search') ? session('admin_commissions_children_search') : $search;

        return view('admin.report.commission-children', [
            'title' => 'Commissions - Downline',
            'submit' => route('report_commission_children'),
            'records' => Commissions::get_record($search)->paginate(10),
            'search' =>  $search,
            'users' => $users,
            'brokers' => Brokers::all(),
            'get_pamm_sel' => Pamm::get_pamm_sel(),
            'get_country_sel' => SettingCountry::get_country_sel(app()->getLocale()),
        ]);
    }

    public function delete(Request $request)
    {
        $commission_id = $request->input('commission_id');
        $commission = Commissions::find($commission_id);
        $user = Auth::user();
        $route = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();

        if (!$commission) {
            Alert::error(trans('public.invalid_commission'), trans('public.try_again'));
            return redirect()->route($route);
        }

        if ($commission->status ==  Commissions::STATUS_CALCULATED) {
            Alert::error(trans('public.invalid_commission'), trans('public.commission_status_error'));
            return redirect()->route($route);
        }

        $commission->delete();

        ActionLogs::create([
            'user_id' => $user->id,
            'type' => get_class($commission),
            'description' => $user->name. ' has DELETED commission with id: '. $commission->id,
        ]);

        Alert::success(trans('public.done'), trans('public.successfully_deleted_commission'));
        return redirect()->route($route);
    }
}
