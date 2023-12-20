<?php

namespace App\Http\Controllers\Web\Admin;

use App\Exports\ExportDeposits;
use App\Http\Controllers\Controller;
use App\Imports\DepositsImport;
use App\Models\ActionLogs;
use App\Models\Brokers;
use App\Models\Deposits;
use App\Models\Pamm;
use App\Models\SettingCountry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Alert;
use Session;

class DepositController extends Controller
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
                    $import = new DepositsImport($request->input('broker_id'), $request->input('pamm_id'));
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
                    $filePath = public_path('WeVenture_Deposit_Import_Template.xlsx');
                    return response()->download($filePath);
            }
        }

        ActionLogs::create([
            'user_id' => $user->id,
            'type' => Deposits::class,
            'description' => $user->name. ' with id: ' . $user->id . ' has imported deposit records',
        ]);

        Alert::success(trans('public.done'), trans('public.import_success'));
        return redirect()->back();
    }

    public function listing(Request $request)
    {
        $search = array();


        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['admin_deposits_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'transaction_start' => $request->input('transaction_start'),
                        'transaction_end' => $request->input('transaction_end'),
                        'country' => $request->input('country'),
                        'pamm_id' => $request->input('pamm_id'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportDeposits( Deposits::get_report_record(session('admin_deposits_search'))), $now . '-deposits-records.xlsx');
                case 'reset':
                    session()->forget('admin_deposits_search');
                    break;
            }
        }

        $search = session('admin_deposits_search') ? session('admin_deposits_search') : $search;

        return view('admin.report.deposit', [
            'title' => 'Deposits',
            'submit' => route('report_deposits'),
            'records' => Deposits::get_report_record($search)->paginate(10),
            'search' =>  $search,
            'brokers' => Brokers::all(),
            'get_pamm_sel' => Pamm::get_pamm_sel(),
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
                    session(['admin_deposits_children_search' => [
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
                    return Excel::download(new ExportDeposits( Deposits::get_report_record(session('admin_deposits_children_search'))), $now . '-deposits-records.xlsx');
                case 'reset':
                    session()->forget('admin_deposits_children_search');
                    break;
            }
        }

        $search = session('admin_deposits_children_search') ? session('admin_deposits_children_search') : $search;

        return view('admin.report.deposit-children', [
            'title' => 'Deposits - Downline',
            'submit' => route('report_deposits_children'),
            'records' => Deposits::get_report_record($search)->paginate(10),
            'search' =>  $search,
            'users' => $users,
            'brokers' => Brokers::all(),
            'get_pamm_sel' => Pamm::get_pamm_sel(),
            'get_country_sel' => SettingCountry::get_country_sel(app()->getLocale()),
        ]);
    }

    public function delete(Request $request)
    {
        $deposit_id = $request->input('deposit_id');
        $pamm_id = $request->input('pamm_id');

        $deposit = Deposits::find($deposit_id);
        $capital_available_in_broker = $deposit->user->withdrawalAmountValidationByBrokers($deposit->brokersId, $pamm_id)->first();
        $user = Auth::user();
        $route = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();

        if (!$deposit) {
            Alert::error(trans('public.invalid_deposit'), trans('public.try_again'));
            return redirect()->route($route);
        }
        if ($deposit->type == Deposits::TYPE_DEPOSIT) {
            if ($deposit->amount > $capital_available_in_broker->amount) {
                Alert::error(trans('public.invalid_action'), trans('public.insufficient_amount'));
                return redirect()->route($route);
            }
        }

        $deposit->delete();

        ActionLogs::create([
            'user_id' => $user->id,
            'type' => get_class($deposit),
            'description' => $user->name. ' has DELETED deposit with id: '. $deposit->id,
        ]);

        Alert::success(trans('public.done'), trans('public.successfully_deleted_deposit'));
        return redirect()->route($route);
    }
}
