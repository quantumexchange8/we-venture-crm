<?php

namespace App\Http\Controllers\Web\Admin;

use App\Exports\ExportPerformanceBonus;
use App\Http\Controllers\Controller;
use App\Models\PerformanceBonus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Alert;
use Maatwebsite\Excel\Facades\Excel;
class PerformanceBonusController extends Controller
{
    public function performance_bonus_listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['admin_performance_bonus_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'created_start' => $request->input('created_start'),
                        'created_end' => $request->input('created_end'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportPerformanceBonus( PerformanceBonus::get_report_record(session('admin_performance_bonus_search'))), $now . '-performance-bonus-records.xlsx');

                case 'reset':
                    session()->forget('admin_performance_bonus_search');
                    break;
            }
        }

        $search = session('admin_performance_bonus_search') ? session('admin_performance_bonus_search') : $search;

        return view('admin.report.performance_bonus', [
            'title' => 'Performance Bonus',
            'submit' => route('performance_bonus_listing'),
            'records' => PerformanceBonus::get_report_record($search)->paginate(10),
            'search' =>  $search,
        ]);
    }

    public function performance_bonus_approval(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in(['approve', 'reject'])],
        ]);

        $approval = $request->input('status');
        $performance_bonus = PerformanceBonus::find($id);
        $user = $performance_bonus->upline;

        if ($performance_bonus->is_claimed != 'pending') {
            Alert::error(trans('public.invalid_action'), trans('public.invalid_status'));
            return back();
        }

        switch ($approval) {
            case 'approve':
                $performance_bonus->update([
                    'is_claimed' => 'approved',
                ]);
                $user->wallet_balance  = $user->wallet_balance + $performance_bonus->bonus_amount;
                $user->save();

                Alert::success(trans('public.done'), trans('public.approve_claim'));
                break;

            case 'reject':
                $performance_bonus->update([
                    'is_claimed' => 'rejected',
                ]);

                Alert::success(trans('public.done'), trans('public.reject_claim'));
                break;
        }

        return back();
    }
}
