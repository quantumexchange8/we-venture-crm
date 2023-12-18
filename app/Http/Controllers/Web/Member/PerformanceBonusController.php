<?php

namespace App\Http\Controllers\Web\Member;

use App\Exports\ExportPerformanceBonus;
use App\Http\Controllers\Controller;
use App\Models\PerformanceBonus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PerformanceBonusController extends Controller
{
    public function listing(Request $request)
    {
        $search = array();
        $user = Auth::user();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['member_performance_bonus_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'created_start' => $request->input('created_start'),
                        'created_end' => $request->input('created_end'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportPerformanceBonus( PerformanceBonus::get_record(session('member_performance_bonus_search'), $user->id)), $now . '-performance-bonus-records.xlsx');

                case 'reset':
                    session()->forget('member_performance_bonus_search');
                    break;
            }
        }

        $search = session('member_performance_bonus_search') ? session('member_performance_bonus_search') : $search;

        return view('member.performance_bonus', [
            'title' => 'Performance Bonus',
            'records' => PerformanceBonus::get_record($search, $user->id)->paginate(10),
            'search' =>  $search,
        ]);
    }
}
