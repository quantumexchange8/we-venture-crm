<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commissions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userGroupDeposits = User::query()
            ->where('hierarchyList', 'like', '%-' . $user->id . '-%')
            ->get(['id', 'name', 'email', 'profile_image', 'wallet_balance', 'kyc_approval_status']);

        for ($i = 0; $i < count($userGroupDeposits); $i++) {
            $userGroupDeposits[$i]->total = $userGroupDeposits[$i]->personalDeposits();
            $userGroupDeposits[$i]->deposits = $userGroupDeposits[$i]->personalDepositsByBrokers()->toArray();
        }

        $user->url = url('') .'/register/' . $user->referral_id;
        $deposits = $user->personalDepositsByBrokers();
        $personal_total = $user->personalDeposits();
        $rank = $user->rank;
        $group_deposits_total = $user->groupTotalDeposit();

        $personalDailyDeposit = $user->userDailyMonthlyDeposit();
        $personalMonthlyDeposit = $user->userDailyMonthlyDeposit(true);
        $groupDailyDeposit = $user->groupDailyMonthlyDeposit();
        $groupDailyWithdrawal = $user->groupDailyMonthlyWithdrawal();
        $groupMonthlyDeposit = $user->groupDailyMonthlyDeposit(true);
        $groupMonthlyWithdrawal = $user->groupDailyMonthlyWithdrawal(true);

        $totalLotSize = number_format(Commissions::getLotSizePool(), 2);

        return response()->json([
            'user' => $user,
            'deposits' => $deposits,
            'personal_total' => $personal_total,
            'group_deposits' => $userGroupDeposits,
            'group_deposits_total' => $group_deposits_total,
            'personalDailyDeposit' => $personalDailyDeposit,
            'personalMonthlyDeposit' => $personalMonthlyDeposit,
            'groupDailyDeposit' => $groupDailyDeposit,
            'groupDailyWithdrawal' => $groupDailyWithdrawal,
            'groupMonthlyDeposit' => $groupMonthlyDeposit,
            'groupMonthlyWithdrawal' => $groupMonthlyWithdrawal,
            'totalLotSize' => $totalLotSize,
        ]);
    }
}
