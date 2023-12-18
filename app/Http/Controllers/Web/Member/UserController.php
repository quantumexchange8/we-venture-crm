<?php

namespace App\Http\Controllers\Web\Member;

use App\Exports\ExportCommissions;
use App\Exports\ExportUser;
use App\Exports\NetworkExport;
use App\Http\Controllers\Controller;
use App\Models\ActionLogs;
use App\Models\Announcements;
use App\Models\Brokers;
use App\Models\Commissions;
use App\Models\Deposits;
use App\Models\Event;
use App\Models\Portfolio;
use App\Models\Rankings;
use App\Models\ResetWithdrawalToken;
use App\Models\SettingCountry;
use App\Models\Settings;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserWallet;
use App\Models\Withdrawals;
use App\Notifications\ResetWithdrawalPinNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Facades\Image;
use Jorenvh\Share\Share;
use Maatwebsite\Excel\Facades\Excel;
use Alert;
use Session;
use Illuminate\Support\Facades\Session as FacadesSession;
use function GuzzleHttp\Promise\all;


class UserController extends Controller
{
    public function welcome_page()
    {
        $user = Auth::user();

        $news = Announcements::query()
            ->where('deleted_at', null)
            ->where('visibility', 1)
            ->whereJsonDoesntContain('user_ids', $user->id)
            ->latest('created_at')
            ->first();

        $events = Event::query()
            ->where('deleted_at', null)
            ->where('visibility', 1)
            ->where('pop_up_status', 1)
            ->whereJsonDoesntContain('user_ids', $user->id)
            ->orderByDesc('created_at')
            ->get();

        $portfolios = Portfolio::query()
            ->where('status', '=', 'active')
            ->whereJsonContains('user_ids', $user->id)
            ->get();

        return view('member.welcome_page', [
            'user' => $user,
            'news' => $news,
            'events' => $events,
            'portfolios' => $portfolios ?? null,
        ]);
    }

    public function dashboard()
    {
        $user = Auth::user();
        $first_time_logged_in = FacadesSession::get('first_time_logged_in');
        $user->url = url('') .'/register/' . $user->referral_id;
        $deposits = $user->personalDepositsByBrokers();
        $personal_total = $user->personalDeposits();
        $rank = $user->rank;
        $group_deposits = $user->groupDepositsByBrokers();
        $group_deposits_total = $user->groupTotalDeposit();
        $news_all = Announcements::query()
            ->where('deleted_at', null)
            ->where('visibility', 1)
            ->whereJsonDoesntContain('user_ids', $user->id)
            ->orderByDesc('created_at')
            ->limit(4)
            ->get();

        $shareFB = (new Share)->page($user->url)->facebook()->getRawLinks();
        $shareTwitter = (new Share)->page($user->url, 'Sign up now to be a part of us! Simple registration through the link!')->twitter()->getRawLinks();
        $shareTelegram = (new Share)->page($user->url, 'Sign up now to be a part of us! Simple registration through the link!')->telegram()->getRawLinks();
        $shareWA = (new Share)->page($user->url, 'Sign up now to be a part of us! Simple registration through the link!')->whatsapp()->getRawLinks();

        $settings = Settings::getKeyValue();
        $app_download_link = $settings['app_download_link'];

        return view('member/dashboard', compact('user', 'deposits', 'rank', 'personal_total', 'group_deposits', 'group_deposits_total', 'news_all', 'shareFB', 'shareTwitter', 'shareTelegram', 'shareWA', 'first_time_logged_in', 'app_download_link'));
    }

    public function profile()
    {
        $user = Auth::user();
        $rank = $user->rank;
        $user_withdrawal_status = Withdrawals::where('requested_by_user', $user->id)->where('status', Withdrawals::STATUS_PENDING)->first();

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

        $user->countryFlag = $userCountry->code ?? null;


        return view('member/profile', [
            'user' => $user,
            'rank' => $rank,
            'country_trans' => $country_trans,
            'countries' => SettingCountry::where('id', '>', 1)->get(),
            'user_withdrawal_status' => $user_withdrawal_status,
        ]);
    }

    public function edit_profile(Request $request)
    {
        $user = Auth::user();
        $country = json_decode($request->country, true);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|regex:/^[a-zA-Z0-9\p{Han}. ]+$/u|max:255',
            'contact_number' => ['required', Rule::unique(User::class)->ignore($user->id)],
            'address' => 'string|required|max:255',
            'country' => 'required|string',
        ])->setAttributeNames([
            'name' => trans('public.name'),
            'contact_number' => trans('public.contact'),
            'address' => trans('public.address'),
            'country' => trans('public.country'),
        ]);

        if (!$validator->passes()){
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {

            $user_profiles = UserProfile::query()
                ->where('user_id', $user->id)
                ->where('status', '=', 'pending')
                ->get();

            if (!empty($user_profiles)) {
                foreach ($user_profiles as $user_profile) {
                    $user_profile->update([
                        'status' => 'cancelled'
                    ]);
                }
            }

            UserProfile::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'email' => $user->email,
                'contact_number' => $request->contact_number,
                'address' => $request->address,
                'country' => $country['name'],
                'status' => 'pending',
            ]);

            return response()->json([
                'status' => 1,
                'msg' => trans('public.wait_admin_approve_request')
            ]);
        }
    }

    public function wallet_address(Request $request)
    {
        $user = Auth::user();
        $user_wallet = $user->user_wallet;
        $user_withdrawal_status = Withdrawals::where('requested_by_user', $user->id)->where('status', Withdrawals::STATUS_PENDING)->first();

        if (!empty($user_wallet))
        {
            if ($user_wallet->wallet_address_request_status == UserWallet::STATUS_PENDING || $user_withdrawal_status)
            {
                return response()->json([
                    'status' => 2,
                    'msg' => trans('public.wait_admin_approve_request')
                ]);
            }

            if ($user_wallet->wallet_address == $request->input('wallet_address'))
            {
                return response()->json([
                    'status' => 3,
                    'msg' => trans('public.wallet_address_enter_same')
                ]);
            }
        }

        $validator = Validator::make($request->all(), [
            'wallet_type' => 'required',
            'wallet_address' => 'required|regex:/T[A-Za-z1-9]{33}/',
        ])->setAttributeNames([
            'wallet_type' => trans('public.wallet_type'),
            'wallet_address' => trans('public.wallet_address'),
        ]);

        if (!$validator->passes()){
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {

            if (empty($user_wallet))
            {
                UserWallet::create([
                    'user_id' => $user->id,
                    'wallet_type' => $request->input('wallet_type'),
                    'wallet_address' => $request->input('wallet_address'),
                    'requested_at' => now(),
                ]);
            } else {
                $user_wallet->update([
                    'wallet_address_request' => $request->input('wallet_address'),
                    'wallet_address_request_status' => UserWallet::STATUS_PENDING,
                    'wallet_status' => UserWallet::STATUS_INACTIVE,
                    'requested_at' => now(),
                ]);
            }

            return response()->json([
                'status' => 1,
                'msg' => trans('public.successfully_save_wallet_address')
            ]);
        }
    }

    public function withdrawal_pin(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'withdrawal_pin' => 'required|digits:6|confirmed|numeric',
            'withdrawal_pin_confirmation' => 'required|same:withdrawal_pin',
            'current_withdrawal_pin' => [
                function ($attribute, $value, $fail) use ($request) {
                    $user = auth()->user();
                    if (!is_null($user->withdrawal_pin) && empty($value)) {
                        $fail(trans('public.current_pin_required'));
                    }
                },
                'digits:6',
            ],
        ])->setAttributeNames([
            'withdrawal_pin' => trans('public.new_withdrawal_pin'),
            'withdrawal_pin_confirmation' => trans('public.withdrawal_pin_confirmation'),
            'current_withdrawal_pin' => trans('public.current_withdrawal_pin'),
        ]);

        if (!$validator->passes()){
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {

            if (!is_null($user->withdrawal_pin) && !Hash::check($request->get('current_withdrawal_pin'), $user->withdrawal_pin)) {

                return response()->json([
                    'status' => 2,
                    'msg' => trans('public.current_pin_invalid')
                ]);
            }

            $user->update([
                'withdrawal_pin' => Hash::make($request->input('withdrawal_pin')),
            ]);

            return response()->json([
                'status' => 1,
                'msg' => trans('public.successfully_save_withdrawal_pin')
            ]);
        }
    }

    public function send_withdrawal_reset_link(Request $request)
    {
        $user = Auth::user();

        Notification::send($user, new ResetWithdrawalPinNotification());

        return response()->json([
            'status' => 1,
            'msg' => trans('public.successfully_save_withdrawal_pin')
        ]);
    }

    public function withdrawal_pin_reset(Request $request)
    {
        $token = $request->token;
        $email = $request->email;
        $user = Auth::user();
        $validator = null;

        if (!$token || !$email) {
            return redirect()->route('member_profile');
        }

        $exp_time = ResetWithdrawalToken::where('email', $email)->where('created_at', '>', Carbon::now()->subMinutes(60))->first();

        if (!$exp_time) {
           Alert::error(trans('public.invalid_action'), trans('public.reset_link_expired'));
           return redirect()->route('member_profile');
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'token' => 'required',
                'email' => 'required|email',
                'withdrawal_pin' => 'required|digits:6|confirmed|numeric',
                'withdrawal_pin_confirmation' => 'required|same:withdrawal_pin',
            ])->setAttributeNames([
                'withdrawal_pin' => trans('public.new_withdrawal_pin'),
                'withdrawal_pin_confirmation' => trans('public.withdrawal_pin_confirmation'),
            ]);

            if (Hash::check($request->get('withdrawal_pin'), $user->withdrawal_pin)) {
                Alert::warning(trans('public.invalid_action'), trans('public.current_same_password'));
                return redirect()->back();
            }

            if ($validator->passes()){
                $user->update([
                    'withdrawal_pin' => Hash::make($request->input('withdrawal_pin')),
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_save_withdrawal_pin'));
                return redirect()->route('member_profile');
            }
        };

        return view('reset-pin', [
            'token' => $token,
            'email' => $email
        ])->withErrors($validator);
    }

    public function verification(Request $request)
    {
        $post = $user = Auth::user();
        $validator = null;
        if ($request->isMethod('post')) {
            if ($user->kyc_approval_status ==  User::KYC_STATUS_VERIFIED)
            {
                Alert::error(trans('public.invalid_action'), trans('public.fail_uploaded_ic'));
                return redirect()->route('member_verification');
            }


                $validator = Validator::make($request->all(), [
                'front_id_image' => 'nullable|image|max:5120',
                'back_id_image' => 'nullable|image|max:5120',
            ])->setAttributeNames([
                'front_id_image' => trans('public.front_id'),
                'back_id_image' => trans('public.back_id'),
            ]);

            if (!$validator->fails()) {
                $front_id_image = $request->file('front_id_image');
                if ($front_id_image) {
                    if ($user->front_id_image) {
                        File::delete('uploads/users/' . $user->front_id_image);
                    }
                    $frontImageName = time() . '_' . uniqid() . '.' . $front_id_image->getClientOriginalExtension();
                    $resize_upload = Image::make($front_id_image->path());
                    $resize_upload->save(public_path('/uploads/users/' . $frontImageName));
                    $user->update([
                        'front_id_image' => $frontImageName
                    ]);
                }


                $back_id_image = $request->file('back_id_image');
                if ($back_id_image) {
                    if ($user->back_id_image) {
                        File::delete('uploads/users/' . $user->back_id_image);
                    }
                    $backImageName = time() . '_' . uniqid() . '.' . $back_id_image->getClientOriginalExtension();
                    $resize_upload = Image::make($back_id_image->path());
                    $resize_upload->save(public_path('/uploads/users/' . $backImageName));
                    $user->update([
                        'back_id_image' => $backImageName
                    ]);
                }

                if ($user->back_id_image && $user->front_id_image) {
                    $user->update([
                        'kyc_approval_status' => User::KYC_STATUS_PENDING_VERIFICATION
                    ]);
                }
                Alert::success(trans('public.done'), trans('public.successfully_uploaded_ic'));
                return redirect()->route('member_verification');
            }
            $post = (object) $request->all();
        }

        return view('member/verification', [
            'user' => $user,
            'post' => $post,
            'get_country_sel' => SettingCountry::get_country_sel(app()->getLocale()),
            'submit' => route('member_verification'),
        ])->withErrors($validator);

    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_image' => 'nullable|image',
        ]);
        $user = Auth::user();
        $profile_image = $request->file('profile_image');
        if ($profile_image) {
            if ($user->profile_image) {
                File::delete('uploads/users/' . $user->profile_image);
            }
            $imageName = pathinfo($profile_image->getClientOriginalName(), PATHINFO_FILENAME) . time() . '.' . $profile_image->getClientOriginalExtension();
            $profile_image->move('uploads/users', $imageName);
            $user->profile_image = $imageName;
            $user->save();
        }
        $rank = $user->rank;
        Alert::success(trans('public.done'), trans('public.successfully_updated_profile'));
        return view('member/profile', compact('user', 'rank'));
    }

    public function account($id)
    {
        //TODO:: abort 404 if the id not belongs to user chilren
        $user = User::findOrFail($id);
        $children = $user->getChildrenIds();
        $directClients = $user->children()->pluck('id')->toArray();

        $brokers = Brokers::all();

        for ($i = 0; $i < $brokers->count(); $i++) {
            $broker = $brokers[$i];

            $personalTotal = Deposits::where('userId', $user->id)
                ->where('brokersId', $broker->id)
                ->where('type', Deposits::TYPE_DEPOSIT)
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
            $downlines = Deposits::where('brokersId', $broker->id)->whereIn('userId', $children)->distinct()->count('userId');
            $clients = Deposits::where('brokersId', $broker->id)->whereIn('userId', $directClients)->distinct()->count('userId');


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


        foreach ($brokers as $broker) {
            $total['total_personal'] += $broker->data['personal_deposit'];
            $total['total_group'] += $broker->data['group_deposit'];
            $total['total_personal_comm'] += $broker->data['personal_commissions'];
            $total['total_group_comm'] += $broker->data['group_commissions'];
        }


        return view('member/account', compact('user', 'brokers', 'total'));
    }

    public function tree(Request $request)
    {
        $search = array();
        $user = Auth::user();
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
                        return Excel::download(new NetworkExport(User::get_member_tree_record(session('tree_network_search')), true), $now . '-network-records.xlsx');

                    case 'reset':
                        session()->forget('tree_network_search');
                        break;
                }
            }

            $search = session('tree_network_search') ? session('tree_network_search') : $search;

            return view('member/tree', [
                'members' => User::get_member_tree_record($search),
                'search' => $search,
            ]);
    }

    public function treeVerification(Request $request, $type)
    {
        $user = Auth::user();

        if ($request->isMethod('post')) {

            $credentials = [
                'email' => $user->email,
                'password' => $request['current_password'],
            ];

            if (Auth::guard('web')->setTTL(1)->attempt($credentials)) {

                FacadesSession::put('tree_verification', Carbon::now()->addMinutes(30));

                return redirect()->route($type);
            } else {
                Alert::error(trans('public.access_denied'), trans('public.invalid_auth'));
                return back()->withErrors(['error_message' => 'Invalid email or password']);
            }
        }


        return view('member/tree-verification', [
            'type' => $type
        ]);
    }

    public function exportExcel(Request $request)
    {
        {
            $user = Auth::user();
            $now = Carbon::now()->format('YmdHis');
            return Excel::download(new NetworkExport($user->id), $now . '-network-records.xlsx');
        }
    }

    public function changePassword(Request $request)
    {
        $validator = null;
        $user_id = Auth::id();
        $user = User::find($user_id);

        if(!$user){
            Alert::error(trans('public.invalid_user'), trans('public.try_again'));
            return redirect('/');
        }
        if($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'current_password' => 'required|min:8',
                'password' => ['required', 'string', 'confirmed',
                    Password::min(6)->letters()->numbers()],
                'password_confirmation' => 'required|same:password'
            ])->setAttributeNames([
                'current_password' => trans('public.current_password'),
                'password' => trans('public.new_password'),
                'password_confirmation' => trans('public.confirm_password'),
            ]);
            if (!$validator->fails()) {

                // The passwords match
                if (!Hash::check($request->get('current_password'), $user->password)) {

                    Alert::error(trans('public.invalid_action'), trans('public.current_password_invalid'));
                    return back();
                }

                // Current password and new password same
                if (strcmp($request->get('current_password'), $request->password) == 0) {
                    Alert::warning(trans('public.invalid_action'), trans('public.current_same_password'));
                    return back();
                }

                $user->password = Hash::make($request->password);
                $user->save();

                Alert::success(trans('public.done'), trans('public.successfully_updated_password'));
                return redirect()->route('member_dashboard');

            }
        }
        return view('change-password')->withErrors($validator);
    }

    public function downline_listing(Request $request)
    {
        $user = Auth::user();
        $start_date =  Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
        $end_date = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');
        $search =   session('member_downline_search') ? session('member_downline_search') : session(['member_downline_search' => [
            'created_start' => $start_date,
            'created_end' => $end_date,
        ]]);

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['member_downline_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'created_start' => $request->input('created_start'),
                        'created_end' => $request->input('created_end'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportUser(User::get_record(session('member_downline_search'), false, $user->id), true), $now . '-users-records.xlsx');
                case 'reset':
                    session(['member_downline_search' => [
                        'created_start' => $start_date,
                        'created_end' => $end_date,
                    ]]);
                    break;
            }
        }

        $search = session('member_downline_search') ? session('member_downline_search') : $search;


        return view('member.downline-listing', [
            'submit' => route('member_downline_listing'),
            'records' => User::get_record($search, false, $user->id)->paginate(10),
            'search' =>  $search,
        ]);
    }

    public function leaveImpersonate()
    {
        $user = Auth::user();
        FacadesSession::put('jwt-token', FacadesSession::get('temp-admin-token'));
        $admin = User::find(FacadesSession::get('impersonate-admin-id'));
        FacadesSession::put('impersonate-admin-id', 0);

        ActionLogs::create([
            'user_id' => $admin->id,
            'type' => get_class($admin),
            'description' =>  'Admin with id: '. $admin->id .' has LEAVE IMPERSONATE user with id: '. $user->id,
        ]);
        return redirect()->route('admin_dashboard');
    }
}

