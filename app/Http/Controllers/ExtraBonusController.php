<?php

namespace App\Http\Controllers;

use App\Exports\ExtraBonusExport;
use App\Models\ActionLogs;
use App\Models\ExtraBonus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Alert;

class ExtraBonusController extends Controller
{
    public function extra_bonus_listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['extra_bonus_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'created_start' => $request->input('created_start'),
                        'created_end' => $request->input('created_end'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExtraBonusExport( ExtraBonus::get_record(session('extra_bonus_search'))), $now . '-extra-bonus-records.xlsx');

                case 'reset':
                    session()->forget('extra_bonus_search');
                    break;
            }
        }

        $search = session('extra_bonus_search') ? session('extra_bonus_search') : $search;

        return view('admin.report.extra_bonus', [
            'title' => 'Extra Bonus',
            'submit' => route('extra_bonus_listing'),
            'records' => ExtraBonus::get_record($search)->paginate(10),
            'search' =>  $search,
        ]);
    }

    public function extra_bonus_delete(Request $request)
    {
        $extra_bonus_id = $request->input('extra_bonus_id');
        $extra_bonus = ExtraBonus::find($extra_bonus_id);
        $user = \Auth::user();

        if (!$extra_bonus) {
            Alert::error(trans('public.invalid_action'), trans('public.try_again'));
            return redirect()->route('extra_bonus_listing');
        }

        $extra_bonus->delete();

        ActionLogs::create([
            'user_id' => $user->id,
            'type' => ExtraBonus::class,
            'description' => 'Admin with id: ' . $user->id . ' has DELETED Extra Bonus with id: ' . $extra_bonus_id,
        ]);

        Alert::success(trans('public.done'), trans('public.successfully_deleted_extra_bonus'));
        return redirect()->route('extra_bonus_listing');
    }
}
