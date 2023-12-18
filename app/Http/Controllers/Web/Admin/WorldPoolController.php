<?php

namespace App\Http\Controllers\Web\Admin;

use App\Exports\WorldPoolHistoryExport;
use App\Http\Controllers\Controller;
use App\Models\ActionLogs;
use App\Models\Withdrawals;
use App\Models\WorldPoolHistory;
use Carbon\Carbon;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Alert;

class WorldPoolController extends Controller
{
    public function world_pool(Request $request)
    {
        $search = [];

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['report_world_pool' => [
                        'freetext' =>  $request->input('freetext'),
                        'created_start' => $request->input('created_start'),
                        'created_end' => $request->input('created_end'),
                        'status' => $request->input('status'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new WorldPoolHistoryExport( WorldPoolHistory::get_record(session('report_world_pool'), 0)), $now . '-world-pool-records.xlsx');
                case 'reset':
                    session()->forget('report_world_pool');
                    break;
            }
        }

        $search = session('report_world_pool') ? session('report_world_pool') : $search;

        return view('admin.report.world_pool', [
            'title' => 'World Pool',
            'submit' => route('world_pool'),
            'records' => WorldPoolHistory::get_record($search, 0)->paginate(10),
            'search' =>  $search,
            'get_status_sel' => ['' => trans('public.select_status')] + [1 => trans('public.process'), 2 => trans('public.approved'), 3 => trans('public.rejected')],
        ]);
    }

    public function world_pool_approval(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in(['approve', 'reject'])],
        ]);

        $approval = $request->input('status');
        $world_pool_history = WorldPoolHistory::find($id);
        $user = $world_pool_history->user;

        if ($world_pool_history->status != WorldPoolHistory::STATUS_PENDING) {
            Alert::error(trans('public.invalid_action'), trans('public.try_again'));
            return back();
        }

        switch ($approval) {
            case 'approve':
                $world_pool_history->update([
                    'status' => WorldPoolHistory::STATUS_APPROVED,
                ]);
                $user->wallet_balance  = $user->wallet_balance + $world_pool_history->pool_amount;
                $user->save();

                ActionLogs::create([
                    'user_id' => Auth::id(),
                    'type' => WorldPoolHistory::class,
                    'description' => Auth::user()->name. ' with id: ' . Auth::id() . ' has approved world pool for ' . $user->name . ' with id: ' . $user->id,
                ]);
                Alert::success(trans('public.done'), trans('public.approved'));
                break;

            case 'reject':
                $world_pool_history->update([
                    'status' => WorldPoolHistory::STATUS_REJECTED,
                ]);

                ActionLogs::create([
                    'user_id' => Auth::id(),
                    'type' => WorldPoolHistory::class,
                    'description' => Auth::user()->name. ' with id: ' . Auth::id() . ' has rejected world pool for ' . $user->name . ' with id: ' . $user->id,
                ]);
                Alert::success(trans('public.done'), trans('public.rejected'));
                break;
        }

        return back();
    }

}
