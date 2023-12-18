<?php

namespace App\Http\Controllers\Web\Admin;

use App\Exports\NetworkExport;
use App\Http\Controllers\Controller;
use App\Models\ActionLogs;
use App\Models\Brokers;
use App\Models\Commissions;
use App\Models\Deposits;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Alert;
use Opcodes\LogViewer\Logs\Log;
use Session;

class ReferralController extends Controller
{
    public function referral_tree(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');
            switch ($submit_type) {
                case 'search':
                    session(['tree_network_search' => [
                        'freetext' => $request->input('freetext'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new NetworkExport(User::get_admin_tree_record(session('tree_network_search'))), $now . '-network-records.xlsx');
                case 'reset':
                    session()->forget('tree_network_search');
                    break;
            }
        }

        $search = session('tree_network_search') ? session('tree_network_search') : $search;

        return view('admin.referral.referral_tree', [
            'members' => User::get_admin_tree_record($search),
            'title' => 'Referral Tree',
            'search' =>  $search,
        ]);
    }

    public function referral_detail(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user)
        {
            Alert::error (trans('public.invalid_user'), trans('public.try_again'));
            return redirect()->back();
        }

        $children = $user->getChildrenIds();
        $directClients = $user->children()->pluck('id')->toArray();

        $brokers = Brokers::all();

        for ($i = 0; $i < $brokers->count(); $i++) {
            $broker = $brokers[$i];

            $personalTotal = Deposits::where('userId', $user->id)
                ->where('brokersId', $broker->id)->where('type', Deposits::TYPE_DEPOSIT)
                ->where('status', Deposits::STATUS_APPROVED)
                ->sum('amount');

            $groupTotal = Deposits::whereIn('userId', $children)
                ->where('brokersId', $broker->id)
                ->where('type', Deposits::TYPE_DEPOSIT)
                ->where('status', Deposits::STATUS_APPROVED)
                ->sum('amount');

            $group_deposit_with= Deposits::whereIn('userId', $children)
                ->where('brokersId', $broker->id)
                ->where('type', Deposits::TYPE_WITHDRAW)
                ->where('status', Deposits::STATUS_APPROVED)
                ->sum('amount');

            $personalWithdrawal = Deposits::where('userId', $user->id)
                ->where('brokersId', $broker->id)
                ->where('type', Deposits::TYPE_WITHDRAW)
                ->where('status', Deposits::STATUS_APPROVED)
                ->sum('amount');

            $groupTotal = $personalTotal + $groupTotal - $group_deposit_with;

            $personalCommissionTotal = Commissions::where('userId', $user->id)->where('brokersId', $broker->id)->sum('commissions_amount');
            $groupCommissionTotal = Commissions::whereIn('userId', $children)->where('brokersId', $broker->id)->sum('commissions_amount');
            $groupCommissionTotal = $personalCommissionTotal + $groupCommissionTotal;
            $downlines = Deposits::where('brokersId',2)->whereIn('userId', $children)->distinct()->count('userId');
            $clients = Deposits::where('brokersId',2)->whereIn('userId', $directClients)->distinct()->count('userId');

            $brokers[$i]->data = [
                'personal_deposit' => $personalTotal - $personalWithdrawal ?? 0,
                'group_deposit' => $groupTotal ?? 0,
                'personal_commissions' => $personalCommissionTotal ?? 0,
                'group_commissions' => $groupCommissionTotal ?? 0,
                'downlines' => $downlines ?? 0,
                'clients' => $clients ?? 0,
            ];
        }

        $total = [
            'total_personal' => 0,
            'total_group' => 0,
            'total_personal_comm' => 0,
            'total_group_comm' => 0,
        ];

        foreach ($brokers as $broker ) {
            $total['total_personal'] += $broker->data['personal_deposit'];
            $total['total_group'] += $broker->data['group_deposit'];
            $total['total_personal_comm'] += $broker->data['personal_commissions'];
            $total['total_group_comm'] += $broker->data['group_commissions'];
        }

        return view('admin.referral.referral_detail', [
            'title' => 'Referral Tree',
            'user' => $user,
            'brokers' => $brokers,
            'total' => $total,
        ]);
    }

    public function referral_transfer(Request $request)
    {
        $users = User::query()
            ->where('status', 1)
            ->where('role', 1)
            ->where('deleted_at', null)
            ->get();

        if ($request->isMethod('post')) {
            $data = $request->all();

            if ($data['user'] == $data['parent']) {
                return back()->withErrors("Both users cannot be same.");
            }
            $user = User::find($data['user']);
            $new_parent = User::find($data['parent']);

            if ($user->upline_referral_id != $new_parent->id) {

                if (str_contains($new_parent->hierarchyList, $user->id)) {
                    $new_parent->hierarchyList = $user->hierarchyList;
                    $new_parent->upline_referral_id = $user->upline_referral_id;
                    $new_parent->save();
                }

                if (empty($new_parent->hierarchyList)) {
                    $user_hierarchy = "-" . $new_parent->id . "-";
                } else {
                    $user_hierarchy = $new_parent->hierarchyList . $new_parent->id . "-";
                }

                $this->updateHierarchyList($user, $user_hierarchy, '-' . $user->id . '-');

                $user->hierarchyList = $user_hierarchy;
                $user->upline_referral_id = $new_parent->id;
                $user->save();

                // Update hierarchyList for users with same upline_referral_id
                $sameUplineIdUsers = User::where('upline_referral_id', $new_parent->id)->get();
                if ($sameUplineIdUsers) {
                    foreach ($sameUplineIdUsers as $sameUplineUser) {
                        $new_user_hierarchy = $new_parent->hierarchyList . $new_parent->id . "-";
                        $this->updateHierarchyList($sameUplineUser, $new_user_hierarchy, '-' . $sameUplineUser->id . '-');
                        $sameUplineUser->hierarchyList = $new_user_hierarchy;
                        $sameUplineUser->upline_referral_id = $new_parent->id;
                        $sameUplineUser->save();
                    }
                }

                ActionLogs::create([
                    'user_id' => Auth::user()->id,
                    'type' => get_class($user),
                    'description' => 'Admin with id: '. Auth::user()->id .' has TRANSFER user ' . $user->name . ', ' . $user->email . ' with id: '. $user->id . ' to ' . $new_parent->email . ' with id: ' . $new_parent->id,
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_transfer_customer'));
                return redirect()->route('referral_tree');
            }
        }

        return view('admin.referral.transfer', [
            'title' => 'Network Transfer',
            'users' => $users,
        ]);
    }

    private function updateHierarchyList($user, $list, $id)
    {
        $children = $user->children;
        if (count($children)) {
            foreach ($children as $child) {
                //$child->hierarchyList = substr($list, -1) . substr($child->hierarchyList, strpos($child->hierarchyList, $id) + strlen($id));
                $child->hierarchyList = substr($list, 0, -1) . $id;
                $child->save();
                $this->updateHierarchyList($child, $list, $id . $child->id . '-');
            }
        }
    }

}
