<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brokers;
use App\Models\Commissions;
use App\Models\Deposits;
use App\Models\SettingCountry;
use App\Models\User;
use App\Models\Withdrawals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Facades\Image;
use Alert;
use Session;

class UserController extends Controller
{
    public function dashboard()
    {
        $total_group_sales = Deposits::getActiveUserDepositAmount();
        $total_withdrawals = Withdrawals::getApprovedWithdrawalAmount();
        $total_commissions = Commissions::getActiveUserCommissionsRebateAmount();
        $total_members = User::getActiveUsersCount();


        $brokers = Brokers::all();

        for ($i = 0; $i < $brokers->count(); $i++) {
            $broker = $brokers[$i];

            $personalTotal = Deposits::where('brokersId', $broker->id)->where('type', Deposits::TYPE_DEPOSIT)->with('user')
                ->whereHas('user', function($q) {
                $q->where('status', User::STATUS_ACTIVE);
                })->sum('amount');

            $personalCommissionTotal = Commissions::where('brokersId', $broker->id)->with('user')
                ->whereHas('user', function($q) {
                    $q->where('status', User::STATUS_ACTIVE);
                })->sum('commissions_amount');

            $clients = Deposits::where('brokersId', $broker->id)->distinct()->count('userId');


            $brokers[$i]->data = [
                'total_deposit' => $personalTotal ?? 0,
                'total_commissions' => $personalCommissionTotal ?? 0,
                'clients' => $clients ?? 0,
            ];
        }

        return view('admin/dashboard', [
            'total_group_sales' => $total_group_sales,
            'total_withdrawals' => $total_withdrawals,
            'total_commissions' => $total_commissions,
            'total_members' => $total_members,
            'brokers' => $brokers,
            'monthly_lot' => Commissions::getMonthlyLotSize(),
            'lot_size_pool' => Commissions::getLotSizePool(),
        ]);
    }

    public function profile(Request $request)
    {
//        dd($request->all());
        $validator = null;
        $user_id = Auth::id();
        $post = $user = User::find($user_id);

        if(!$user){
            Alert::flash(trans('public.invalid_user'), trans('public.try_again'));
            return redirect()->route('admin_dashboard');
        }

        if($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'name' => 'required|regex:/^[a-zA-Z0-9\p{Han}. -_]+$/u|max:100',
                'email' => "required|unique:users,email,{$user->id},id",
                'contact_number' => "required|unique:users,contact_number,{$user_id},id",
                'country' => 'required',
                'profile_image' => 'nullable|image',
            ])->setAttributeNames([
                'name' => trans('public.name'),
                'email' => trans('public.email'),
                'contact_number' => trans('public.contact'),
                'country' => trans('public.country'),
                'profile_image' => trans('public.profile_image'),
            ]);

            if (!$validator->fails()) {
                $user->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'contact_number' => $request->input('contact_number'),
                    'country' => $request->input('country'),
                ]);

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

                Alert::success(trans('public.done'), trans('public.successfully_updated_profile'));
                return redirect()->route('admin_dashboard');
            }
            $post = (object) $request->all();
        }

        return view('admin.profile', [
            'title' => 'Edit',
            'user' => $user,
            'post' => $post,
            'get_country_sel' => SettingCountry::get_country_sel(app()->getLocale()),
            'submit' => route('admin_profile'),
        ])->withErrors($validator);
    }

    public function change_password(Request $request)
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

                if (!Hash::check($request->get('current_password'), $user->password)) {

                    Alert::error(trans('public.invalid_action'), trans('public.current_password_invalid'));
                    return back();
                }

                if (strcmp($request->get('current_password'), $request->password) == 0) {
                    Alert::warning(trans('public.invalid_action'), trans('public.current_same_password'));
                    return back();
                }

                $user->password = Hash::make($request->password);
                $user->save();

                Alert::success(trans('public.done'), trans('public.successfully_updated_password'));
                return redirect()->route('admin_dashboard');

            }
        }

        return view('admin.change-password')->withErrors($validator);
    }
}
