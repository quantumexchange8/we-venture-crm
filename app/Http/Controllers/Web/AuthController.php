<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Models\Rankings;
use App\Models\SettingCountry;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Password as PasswordSupport;
use Alert;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class AuthController extends Controller
{
    public function guard()
    {
        return Auth::guard('web');
    }

    public function getLogin(Request $request)
    {
        return view('welcome');
    }


    public function postLogin(Request $request)
    {
        $validator = null;

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string',
                Password::min(6)->letters()->numbers()],
        ])->setAttributeNames([
            'email' => trans('public.email'),
            'password' => trans('public.password'),
        ]);

        if (!$validator->fails())
        {
            $credentials = [
                'email' => $request['email'],
                'password' => $request['password'],
                'status' => User::STATUS_ACTIVE
            ];
            $remember = $request->filled('remember');
            $token_duration = 1440;
            if($remember) {
                $token_duration = 525960;
            }

            if ($token = $this->guard()->setTTL($token_duration)->attempt($credentials)) {
                Session::put('jwt-token', $token);
                Session::put('first_time_logged_in', 0);
                if (Auth::user()->role === 1) {
                    Session::put('first_time_logged_in', 1);
                    return redirect('member/welcome_page');
                } else if (Auth::user()->role === 2) {
                    return redirect('admin/dashboard');
                }
            }

            Alert::error(trans('public.access_denied'), trans('public.invalid_auth'));
            return back()->withErrors(['error_message' => 'Invalid email or password']);
        }
        return redirect('welcome')->withErrors($validator);
    }

    public function getRegister(Request $request, $referral = null)
    {
        $countries = SettingCountry::where('id', '>', 1)->get();

        return view('register', compact('countries', 'referral'));
    }

    public function postRegister(UserRegisterRequest $request)
    {
        $hierarchyList = null;
        $upline_user_id = null;
        $phoneNumber = str_replace(' ', '', $request->phone);

        if ($request->referral) {
            $temp_user = User::where('referral_id', $request->referral)->first();
            if (!$temp_user) {
                Alert::error(trans('public.invalid_action'), trans('public.invalid_referral_code'));
                return back()->withInput($request->input())->withErrors(['error_messages'=>'Invalid referral code!']);
            }
            $upline_user_id = $temp_user->id;
            if (empty($temp_user['hierarchyList'])) {
                $hierarchyList = "-" . $upline_user_id . "-";
            } else {
                $hierarchyList = $temp_user['hierarchyList'] . $upline_user_id . "-";
            }
        }

        $country = json_decode($request->country, true);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'country' => $country['name'],
            'contact_number' => $phoneNumber,
            'rankId'=> Rankings::where('position', 1)->first()->id,
            'upline_referral_id' => $upline_user_id,
            'hierarchyList' => $hierarchyList,
            'kyc_approval_status' => 3
        ]);
        if ($user) {
            $user->setReferralId();

            if ($upline_user_id) {
                $upline_user = User::find($upline_user_id);

                if ($upline_user && $upline_user->email_status == 1) {
                    $user->update([
                        'email_status' => 1
                    ]);
                }
            }

            Alert::success(trans('public.done'), trans('public.success_register'));
            return redirect('welcome');
        }
        return back()->withInput($request->input())->withErrors(['error_messages'=>'Fail to crate user, please try again!']);
    }

    public function getForgotPassword(Request $request)
    {
        return view('forgot-password');
    }

    public function postForgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = PasswordSupport::sendResetLink(
            ['email' => $request->email]
        );
        return $status === PasswordSupport::RESET_LINK_SENT
            ? back()->with(['success_msg' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function getResetPassword(Request $request)
    {
        $token = $request->token;
        $email = $request->email;

        if (!$token || !$email) {
            return redirect('welcome');
        }
        return view('reset-password', ['token' => $token, 'email' => $email]);
    }

    public function postResetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'string', 'confirmed',
                Password::min(6)->letters()->numbers()],
        ]);

        $status = PasswordSupport::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
                Alert::success(trans('public.done'), trans('public.success_reset'));
            }
        );
        return $status === PasswordSupport::PASSWORD_RESET
            ? redirect()->route('welcome')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function logout()
    {
        $this->guard()->logout();
        session()->invalidate();
        return redirect('welcome');
    }
}
