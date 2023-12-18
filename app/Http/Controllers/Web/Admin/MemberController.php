<?php

namespace App\Http\Controllers\Web\Admin;

use App\Exports\DeletedUsersExport;
use App\Exports\ExportUser;
use App\Http\Controllers\Controller;
use App\Models\ActionLogs;
use App\Models\Brokers;
use App\Models\Deposits;
use App\Models\ExtraBonus;
use App\Models\Pamm;
use App\Models\Rankings;
use App\Models\SettingCountry;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserWallet;
use App\Models\WalletLogs;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use Alert;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use Session;

class MemberController extends Controller
{
    public function member_listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['member_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'created_start' => $request->input('created_start'),
                        'created_end' => $request->input('created_end'),
                        'status' => $request->input('status'),
                        'auto_rank_up' => $request->input('auto_rank_up'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportUser(User::get_record(session('member_search'))), $now . '-users-records.xlsx');
                case 'reset':
                    session()->forget('member_search');
                    break;
            }
        }

        $search = session('member_search') ? session('member_search') : $search;


        return view('admin.member.listing', [
            'submit' => route('member_listing'),
            'records' => User::get_record($search)->paginate(10),
            'search' =>  $search,
            'get_status_sel' => [ 'members' => trans('public.members'), 'leaders' => trans('public.leader') ],
            'get_auto_rank_up_sel' => [ '' => trans('public.choose_auto_rank_up_status'), 0 => trans('public.manual'), 1 => trans('public.auto') ],
        ]);
    }

    public function member_add(Request $request)
    {
        $validator = null;
        $post = null;

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|regex:/^[a-zA-Z0-9\p{Han}. -_]+$/u|max:100',
                'contact_number' => "required|unique:users,contact_number",
                'email' => "required|unique:users,email",
                'password' => ['required', 'string', 'confirmed',
                    Password::min(6)->letters()->numbers()],
                'role' => 'required',
                'rankId' => 'required',
                'address' => 'required|max:255',
                'country' => 'required',
                'status' => 'required',
                'leader_status' => 'required',
//                'profile_image' => 'nullable|image',
            ])->setAttributeNames([
                'name' => trans('public.name'),
                'contact_number' => trans('public.contact'),
                'email' => trans('public.email'),
                'password' => trans('public.password'),
                'confirm_password' => trans('public.password_confirmation'),
                'address' => trans('public.address'),
                'role' => trans('public.role'),
                'rankId' => trans('public.rank'),
                'country' => trans('public.country'),
                'status' => trans('public.status'),
                'leader_status' => trans('public.leader_status'),
//                'profile_image' => 'Profile Image'
            ]);

            if (!$validator->fails()) {
                 $user = User::create([
                    'name' => $request->input('name'),
                    'contact_number' => $request->input('contact_number'),
                    'email' => $request->input('email'),
                    'password' => bcrypt($request->input('password')),
                    'role' => $request->input('role'),
                    'address' => $request->input('address'),
                    'rankId' => $request->input('rankId'),
                    'country' => $request->input('country'),
                    'status' => $request->input('status'),
                    'leader_status' => $request->input('leader_status'),
                ]);
                $user->setReferralId();
                Alert::success(trans('public.done'), trans('public.successfully_added_member'));
                return redirect()->route('member_listing');
            }

            $post = (object) $request->all();
        }

        return view('admin.member.form', [
           'title' => 'Add',
           'post' => $post,
           'submit' => route('member_add'),
            'get_role_sel' => [1 => trans('public.member'), 2 => trans('public.admin')],
            'get_rank_sel' => Rankings::get_rank_sel(),
            'get_status_sel' => [ 1 => 'Active', 2 => 'Inactive' ],
            'get_leader_status_sel' => [ 0 => 'No', 1 => 'Yes' ],
            'get_country_sel' => SettingCountry::get_country_sel(app()->getLocale()),
        ])->withErrors($validator);
    }

    public function member_edit(Request $request, $id)
    {
        $validator = null;
        $post = User::withTrashed()->where('id', $id)->first();
        $user = User::withTrashed()->where('id', $id)->first();

        if (!$user)
        {
            Alert::error(trans('public.invalid_user'), trans('public.try_again'));
            return redirect()->back();
        }

        $post->password = 'Testtest__123';

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|regex:/^[a-zA-Z0-9\p{Han}. -_]+$/u|max:100',
                'contact_number' => "required|unique:users,contact_number,{$user->id},id",
                'email' => "required|unique:users,email,{$user->id},id",
                'password' => ['required', 'string', 'confirmed',
                    Password::min(6)->letters()->numbers()],
                'rankId' => 'required',
                'country' => 'required',
                'address' => 'required',
                'status' => 'required',
                'profile_image' => 'nullable|image',
                'leader_status' => 'required',
            ])->setAttributeNames([
                'name' => trans('public.name'),
                'contact_number' => trans('public.contact'),
                'email' => trans('public.email'),
                'password' => trans('public.password'),
                'rankId' => trans('public.rank'),
                'country' => trans('public.country'),
                'address' => trans('public.address'),
                'status' => trans('public.status'),
                'profile_image' => trans('public.profile_image'),
                'leader_status' => trans('public.leader_status'),
            ]);

            if (!$validator->fails()) {
                $update_detail = [
                    'name' => $request->input('name'),
                    'contact_number' => $request->input('contact_number'),
                    'email' => $request->input('email'),
                    'rankId' => $request->input('rankId'),
                    'country' => $request->input('country'),
                    'status' => $request->input('status'),
                    'address' => $request->input('address'),
                    'leader_status' => $request->input('leader_status'),
                ];

                $profile_image = $request->file('profile_image');
                if ($profile_image) {
                    if ($user->profile_image) {
                        File::delete('uploads/users/' . $user->profile_image);
                    }
                    $imageName = time() . '.' . $profile_image->getClientOriginalExtension();
                    $resize_upload = Image::make( $profile_image->path() )
                        ->fit(250, 250);
                    $resize_upload->save(public_path('/uploads/users/'.$imageName));
                    $user->profile_image = $imageName;
                    $user->save();
                }

                if ($request->input('password') != 'Testtest__123') {
                    $update_detail['password'] = Hash::make($request->input('password'));
                }
                $user->update($update_detail);

                if ($update_detail['status']) {
                    switch ($update_detail['status']) {
                        case 1:
                            if ($user->trashed()) {
                                $user->restore();
                            }
                            Alert::success(trans('public.done'), trans('public.successfully_updated_member'));
                            return redirect()->route('member_details', $id);

                        case 2:
                            $user->delete();

                            Alert::success(trans('public.done'), trans('public.successfully_updated_member'));
                            return redirect()->route('deleted_member');
                    }
                }
            }

            $post = (object) $request->all();
        }

        return view('admin.member.form', [
            'user' => $user,
            'post' => $post,
            'title' => 'Edit',
            'submit' => route('member_edit', $id),
            'get_role_sel' => [1 => 'Member', 2 => 'Admin'],
            'get_rank_sel' => Rankings::get_rank_sel(),
            'get_status_sel' => [ 1 => 'Active', 2 => 'Inactive'],
            'get_leader_status_sel' => [ 0 => 'No', 1 => 'Yes' ],
            'get_country_sel' => SettingCountry::get_country_sel(app()->getLocale()),
        ])->withErrors($validator);
    }

    public function member_details(Request $request, $id)
    {
        $post = $user = User::withTrashed()->where('id', $id)->first();
        $validator = null;
        switch (app()->getLocale()) {
            case 'en':
                $userCountry = SettingCountry::where('name', $user->country)->first();
                $country_trans = $user->country;

                break;

            case 'cn':
                $userCountry = SettingCountry::where('name', $user->country)->first();
                $country_trans = $userCountry->name_cn;

                break;

            case 'tw':
                $userCountry = SettingCountry::where('name', $user->country)->first();
                $country_trans = $userCountry->name_tw;

                break;

            default:
                $userCountry = SettingCountry::where('name', $user->country)->first();
                $country_trans = $user->country;
        }

        if (!$user) {
            Alert::error(trans('public.invalid_user'), trans('public.try_again'));
            return redirect()->back();
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'rankId' => 'required',
            ])->setAttributeNames([
                'rankId' => 'Change Ranking',
            ]);

            if (!$validator->fails()) {
                $user->update([
                    'rankId' => $request->input('rankId'),
                    'auto_rank_up' => $request->input('auto_rank_up') == 'on' ? 1 : 0,
                    'rank_update_at' => Carbon::now()->toDateTimeString(),
                    'lowest_rank' => $request->input('lowest_rank'),
                ]);

                ActionLogs::create([
                    'user_id' => Auth::id(),
                    'type' => get_class($user),
                    'description' => Auth::user()->name . ' with id: ' . Auth::id() . ' has UPDATE ' . $user->name . ', ID: ' . $user->id . ' rank to ' . $user->rankId,
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_updated_rank'));
                return redirect()->route('member_details', $id);
            }

            $post = (object) $request->all();
        }

        return view('admin.member.detail', [
            'user' => $user,
            'post' => $post,
            'get_rank_sel' => Rankings::get_rank_sel(),
            'country_trans' => $country_trans,
        ])->withErrors($validator);
    }

    public function member_deposit(Request $request, $id)
    {
        $search = array();

        $user = User::find($id);
        $rank = $user->rank;

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

//            dd($request->all());
            switch ($submit_type) {
                case 'search':
                    session(['deposit_search' => [
                        'brokersId' => $request->input('brokersId'),
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

        $total_deposit = $user->personalDeposits();

        $deposit_by_group = $user->personalDepositsByBrokers();

        return view('admin.member.deposit', [
            'user' => $user,
            'total_deposit' => $total_deposit,
            'deposits' => Deposits::get_record($search, $id, 8),
            'deposit_by_group' => $deposit_by_group,
            'get_pamm_sel' => Pamm::get_pamm_sel(),
            'get_broker_sel' => ['' => trans('public.choose_broker')] + Brokers::get_broker_sel(),
        ]);
    }

    public function fund_adjustmnent(Request $request)
    {
        $user = User::find($request->user_id);

        if ($user->kyc_approval_status != User::KYC_STATUS_VERIFIED)
        {
            return response()->json([
                'status' => 2,
                'msg' => trans('public.kyc_not_verify')
            ]);
        }

        $validator = Validator::make($request->all(), [
            'type' => 'required' ,
            'brokersId' => 'required',
            'pamm_id' => 'required',
            'amount' => 'required|numeric',
        ])->setAttributeNames([
            'type' => trans('public.type'),
            'brokersId' => trans('public.brokers'),
            'pamm_id' => trans('public.pamm'),
            'amount' => trans('public.amount'),
        ]);

        if (!$validator->passes()){
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $type = $request->type;
            $amount = $request->input('amount');
            $broker_id = $request->input('brokersId');
            $pamm_id = $request->input('pamm_id');
            $user_id = $request->input('user_id');

            if ($type != 1) {

                $deposits = Deposits::query()
                    ->where('userId', $user_id)
                    ->where('brokersId', $broker_id)
                    ->where('type', 1)
                    ->where(function ($query) use ($pamm_id) {
                        $query->where('pamm_id', $pamm_id)
                            ->orWhere('pamm_id', 0);
                    })
                    ->where('status', 2)
                    ->where('deleted_at', null)
                    ->get();

                if ($deposits->isEmpty()) {
                    return response()->json([
                        'status' => 2,
                        'msg' => trans('public.invalid_withdrawal')
                    ]);
                }

                foreach ($deposits as $deposit) {
                    if ($deposit->pamm_id == 0) {
                        if ($user->withdrawalAmountValidationByBrokers($broker_id, 0)) {
                            foreach ($user->withdrawalAmountValidationByBrokers($broker_id, 0) as $withdrawal_amount) {
                                if ($amount > $withdrawal_amount->amount) {
                                    return response()->json([
                                        'status' => 2,
                                        'msg' => trans('public.insufficient_amount')
                                    ]);
                                }
                            }
                        }
                    } else {
                        if ($user->withdrawalAmountValidationByBrokers($broker_id, $pamm_id)) {
                            foreach ($user->withdrawalAmountValidationByBrokers($broker_id, $pamm_id) as $withdrawal_amount) {
                                if ($amount > $withdrawal_amount->amount) {
                                    return response()->json([
                                        'status' => 2,
                                        'msg' => trans('public.insufficient_amount')
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            Deposits::create([
                'brokersId' => $broker_id,
                'pamm_id' => $pamm_id,
                'amount' => $amount,
                'userId' => $user_id,
                'type' => $type,
                'transaction_at' => now(),
            ]);

            if ($type == 1) {
                $actionDescription = Auth::user()->name . ' has DEPOSIT $' . $amount . ' to User Name: ' . $user->name . ', ID: ' . $user_id;
            } elseif ($type == 2) {
                $actionDescription = Auth::user()->name . ' has WITHDRAW $' . $amount . ' from User Name: ' . $user->name . ', ID: ' . $user_id;
            } else {
                $actionDescription = Auth::user()->name . 'perform Error Action on deposit/withdraw'; // Default description if $type is neither 1 nor 2
            }

            ActionLogs::create([
                'user_id' => Auth::id(),
                'type' => Deposits::class,
                'description' => $actionDescription,
            ]);

            return response()->json([
                'status' => 1,
                'msg' => trans('public.success_adjust_fund'),
            ]);
        }
    }

    public function transfer_network(Request $request)
    {
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
        }
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

    public function impersonate(Request $request)
    {
        if ($request->user_id) {
            $admin =  Auth::user();
            FacadesSession::put('impersonate-admin-id', $admin->id);
            FacadesSession::put('temp-admin-token', FacadesSession::get('jwt-token'));
            $user = User::find($request->user_id);
            $token = Auth::fromUser($user);
            FacadesSession::put('jwt-token', $token);
            ActionLogs::create([
                'user_id' => $admin->id,
                'type' => get_class($user),
                'description' =>  'Admin with id: '. $admin->id .' has IMPERSONATE user with id: '. $user->id,
            ]);
            return redirect()->route('welcome_page');
        }


        Alert::error(trans('public.invalid_action'), trans('public.try_again'));
        return redirect()->route('member_listing');
    }

    public function member_kyc_listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['member_kyc_search' => [
                        'freetext' =>  $request->input('freetext'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('member_kyc_search');
                    break;
            }
        }

        $search = session('member_kyc_search') ? session('member_kyc_search') : $search;

        return view('admin.member.kyc-approval', [
            'submit' => route('member_kyc_listing'),
            'records' => User::get_record($search, true)->paginate(10),
            'search' =>  $search,
            'title' => 'KYC Approval'
        ]);
    }

    public function approval(Request $request)
    {
        $user = User::find($request->input('user_id'));
        $direct_approve = $request->input('direct_approve');

        if (!$direct_approve && $user->kyc_approval_status != User::KYC_STATUS_PENDING_VERIFICATION) {
            Alert::warning(trans('public.invalid_action'), trans('public.invalid_status'));

            return back();

        } else if ($user->kyc_approval_status == User::KYC_STATUS_VERIFIED) {
            Alert::warning(trans('public.invalid_action'), trans('public.user_verified'));

            return back();
        }

        $user->kyc_approval_status = $request->input('approval');
        $user->save();

        ActionLogs::create([
            'user_id' => Auth::user()->id,
            'type' => get_class($user),
            'description' => 'Admin with id: '. Auth::user()->id .' has APPROVED KYC of user ' . $user->name . ', ' . $user->email . ' with id: '. $user->id,
        ]);

        Alert::success(trans('public.done'), trans('public.successfully_approve_kyc'));
        return redirect()->back();
    }

    public function adjustWallet(Request $request)
    {
        $request->validate([
            'adjust_amount' => 'required|numeric',
            'adjust_remark' => 'nullable|string|max:255',
        ]);
        $user = User::find($request->user_id);

        if ($user) {
            $old_amount = $user->wallet_balance;

            $user->wallet_balance = $request->input('adjust_amount');
            $user->save();

            WalletLogs::create([
                'old_balance' => $old_amount,
                'new_balance' => $user->wallet_balance,
                'type' => 'wallet_adjustment',
                'amount' => $user->wallet_balance - $old_amount,
                'remark' => $request->input('adjust_remark'),
                'user_id' => $user->id,
            ]);

            Alert::success(trans('public.done'), trans('public.success_to_adjust_wallet'));
        } else {
            Alert::warning(trans('public.invalid_action'), trans('public.fail_to_adjust_wallet'));
        }

        return back();
    }

    public function member_extra_bonus(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'bonus_amount' => 'required|numeric',
        ])->setAttributeNames([
            'bonus_amount' => trans('public.amount'),
        ]);

        if (!$validator->passes()){
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $user_id = $request->user_id;
            $user_extra_bonus = ExtraBonus::withTrashed()->where('user_id', $user_id)->first();

            if (empty($user_extra_bonus)) {
                $actionDescription = 'has CREATED';
                $user_extra_bonus = ExtraBonus::create([
                    'user_id' => $user_id,
                    'bonus_amount' => $request->input('bonus_amount'),
                ]);
            } elseif ($user_extra_bonus->trashed()) {
                $actionDescription = 'has RESTORED & UPDATED';
                $user_extra_bonus->restore();
            } else {
                $actionDescription = 'has UPDATED';
            }

            $user_extra_bonus->update([
                'bonus_amount' => $request->input('bonus_amount'),
            ]);

            ActionLogs::create([
                'user_id' => $user->id,
                'type' => ExtraBonus::class,
                'description' => 'Admin with id: ' . $user->id . ' ' . $actionDescription . ' Extra Bonus with id: ' . $user_extra_bonus->id,
            ]);

            return response()->json([
                'status' => 1,
                'msg' => trans('public.successfully_added_extra_bonus'),
            ]);
        }
    }

    public function acknowledgement_letter(Request $request)
    {
        $validator = null;
        $post = null;
        $user_id = $request->input('user');
        $user = User::find($user_id);

        $users = User::query()
            ->where('status', User::STATUS_ACTIVE)
            ->where('role', User::ROLE_MEMBER)
            ->where('deleted_at', null)
            ->get();

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'user' => 'required',
            ])->setAttributeNames([
                'user' => trans('public.user'),
            ]);

            if (!$validator->fails()) {
                $send_email_type = $request->input('send_email_type');

                if ($send_email_type == 'personal') {

                    if ($user->email_status == 0 || $user->email_sent == 1) {
                        Alert::error(trans('public.invalid_action'), trans('public.status_not_allow'));
                        return redirect()->back();
                    }

                    $data['email'] = $user->email;
                    $data['title'] = 'Important Information Regarding Your Investment with Clark Well Capital 关于您在汇佳资本的投资的重要信息';

                    $html = view('admin.member.acknowledgement_pdf', ['user' => $user])->render();

                    $pdf = PDF::loadHTML($html);
                    $pdfContent = $pdf->output();

                    Mail::send('email', ['user' => $user], function ($message) use ($data, $pdfContent, $user) {
                        $message->to($data['email'])
                            ->subject($data['title'])
                            ->attachData($pdfContent, $user->name . '.pdf');
                    });

                    $user->update([
                        'email_sent' => 1
                    ]);

                } elseif ($send_email_type == 'group') {

                    $data['title'] = 'Important Information Regarding Your Investment with Clark Well Capital 关于您在汇佳资本的投资的重要信息';

                    $user_children_ids = $user->getChildrenIds();
                    $user_children_ids[] = $user->id;

                    foreach ($user_children_ids as $child_id) {
                        $child = User::find($child_id);

                        if ($child->email_status == 1 && $child->email_sent == 0) {
                            // Proceed to send email for children with email_status equal to 1 and email_sent equal to 0
                            $data['email'] = $child->email;

                            $html = view('admin.member.acknowledgement_pdf', ['user' => $child])->render();

                            $pdf = PDF::loadHTML($html);
                            $pdfContent = $pdf->output();

                            Mail::send('email', ['user' => $child], function ($message) use ($data, $pdfContent, $child) {
                                $message->to($data['email'])
                                    ->subject($data['title'])
                                    ->attachData($pdfContent, $child->name . '.pdf');
                            });

                            $child->update([
                                'email_sent' => 1
                            ]);
                        }

                    }


                } else {
                    Alert::success(trans('public.invalid_action'), trans('public.try_again'));
                    return redirect()->back();
                }

                Alert::success(trans('public.done'), trans('public.successfully_send_acknowledgement'));
                return redirect()->back();
            }

            $post = (object) $request->all();

        }

        return view('admin.member.send_letter', [
            'post' => $post,
            'users' => $users,
            'submit' => route('acknowledgement_letter'),
            'title' => trans('public.acknowledgement_letter'),
            'get_withdrawal_sel' => [User::ENABLE_WITHDRAWAL => trans('public.enable'), User::DISABLE_WITHDRAWAL => trans('public.disable')],
        ])->withErrors($validator);
    }

    public function deleted_member(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['deleted_member_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'created_start' => $request->input('created_start'),
                        'created_end' => $request->input('created_end'),
                        'status' => $request->input('status'),
                        'auto_rank_up' => $request->input('auto_rank_up'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new DeletedUsersExport(User::get_deleted_record(session('deleted_member_search'))), $now . '-deleted-users-records.xlsx');
                case 'reset':
                    session()->forget('deleted_member_search');
                    break;
            }
        }

        $search = session('deleted_member_search') ? session('deleted_member_search') : $search;


        return view('admin.report.deleted_member', [
            'submit' => route('deleted_member'),
            'records' => User::get_deleted_record($search)->paginate(10),
            'search' =>  $search,
            'get_status_sel' => [ 'members' => trans('public.members'), 'leaders' => trans('public.leader') ],
            'get_auto_rank_up_sel' => [ '' => trans('public.choose_auto_rank_up_status'), 0 => trans('public.manual'), 1 => trans('public.auto') ],
        ]);
    }

    public function member_wallet(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['member_wallet_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'created_start' => $request->input('created_start'),
                        'created_end' => $request->input('created_end'),
                        'wallet_address_request_status' => $request->input('wallet_address_request_status'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('member_wallet_search');
                    break;
            }
        }

        $search = session('member_wallet_search') ? session('member_wallet_search') : $search;

        return view('admin.member.member_wallet', [
            'title' => trans('public.member_wallet'),
            'submit' => route('member_wallet'),
            'records' => UserWallet::get_record($search, 10),
            'search' =>  $search,
            'brokers' => Brokers::all(),
            'get_status_sel' => ['' => trans('public.select_status')] + [1 => trans('public.pending'), 2 => trans('public.approved'), 3 => trans('public.rejected')],
        ]);
    }

    public function member_wallet_approval(Request $request, $id)
    {
        $request->validate([
            'wallet_address_request_status' => ['required', Rule::in(['approve', 'reject'])],
        ]);
        $user_wallet = UserWallet::find($id);

        if ($user_wallet->wallet_address_request_status != UserWallet::STATUS_PENDING) {
            Alert::error(trans('public.invalid_action'), trans('public.try_again'));
            return back();
        }

        switch ($request->input('wallet_address_request_status')) {
            case 'approve':
                $user_wallet->update([
                    'wallet_address_request_status' => UserWallet::STATUS_APPROVED,
                    'wallet_status' => UserWallet::STATUS_ACTIVE,
                    'wallet_address' => $user_wallet->wallet_address_request,
                    'wallet_address_request' => null,
                ]);

                ActionLogs::create([
                    'user_id' => Auth::user()->id,
                    'type' => get_class($user_wallet),
                    'description' => 'Admin with id: '. Auth::user()->id .' has APPROVE user wallet of ' . $user_wallet->wallet_address,
                ]);
                break;

            case 'reject':
                $user_wallet->update([
                    'wallet_address_request_status' => UserWallet::STATUS_REJECTED,
                    'wallet_status' => UserWallet::STATUS_ACTIVE,
                    'wallet_address_request' => null,
                ]);

                ActionLogs::create([
                    'user_id' => Auth::user()->id,
                    'type' => get_class($user_wallet),
                    'description' => 'Admin with id: '. Auth::user()->id .' has REJECT user wallet of ' . $user_wallet->wallet_address,
                ]);
                break;
        }

        Alert::success(trans('public.done'), trans('public.successfully_update_request'));
        return back();
    }

    public function member_profile_request(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['member_profile_request_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'created_start' => $request->input('created_start'),
                        'created_end' => $request->input('created_end'),
                        'status' => $request->input('status'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('member_profile_request_search');
                    break;
            }
        }

        $search = session('member_profile_request_search') ? session('member_profile_request_search') : $search;

        return view('admin.member.member_profile_request', [
            'title' => trans('public.member_profile'),
            'submit' => route('member_profile_request'),
            'records' => UserProfile::get_record($search, 10),
            'search' =>  $search,
            'brokers' => Brokers::all(),
            'get_status_sel' => ['' => trans('public.select_status')] + ['pending' => trans('public.pending'), 'approved' => trans('public.approved'), 'rejected' => trans('public.rejected'), 'cancelled' => trans('public.cancelled')],
        ]);
    }

    public function member_profile_approval(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in(['approve', 'reject'])],
        ]);
        $user_profile = UserProfile::find($id);

        if ($user_profile->status != 'pending') {
            Alert::error(trans('public.invalid_action'), trans('public.try_again'));
            return back();
        }

        switch ($request->input('status')) {
            case 'approve':
                $user_profile->update([
                    'status' => 'approved',
                ]);

                $user = User::find($user_profile->user_id);

                $user->update([
                   'name' => $user_profile->name,
                   'contact_number' => $user_profile->contact_number,
                   'country' => $user_profile->country,
                   'address' => $user_profile->address,
                ]);

                ActionLogs::create([
                    'user_id' => Auth::user()->id,
                    'type' => get_class($user_profile),
                    'description' => 'Admin with id: '. Auth::user()->id .' has APPROVE user profile of ID: ' . $user_profile->id,
                ]);

                break;

            case 'reject':
                $user_profile->update([
                    'status' => 'rejected',
                ]);

                ActionLogs::create([
                    'user_id' => Auth::user()->id,
                    'type' => get_class($user_profile),
                    'description' => 'Admin with id: '. Auth::user()->id .' has REJECT user profile of ID: ' . $user_profile->id,
                ]);
                break;
        }

        Alert::success(trans('public.done'), trans('public.successfully_update_request'));
        return back();
    }
}
