<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActionLogs;
use App\Models\Commissions;
use App\Models\Settings;
use App\Models\User;
use FontLib\Table\Type\post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Alert;

class SettingController extends Controller
{
    public function listing(Request $request)
    {
        return view('admin.setting.listing', [
            'settings' => Settings::query()->paginate(10),
        ]);
    }

    public function setting_edit(Request $request, $id)
    {
        $validator = null;
        $post = $setting = Settings::find($id);
        $user = Auth::user();

        if (!$setting) {
            Alert::error(trans('public.invalid_setting'), trans('public.try_again'));
            return redirect()->back();
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'value' => 'required',
            ])->setAttributeNames([
                'value' => trans('public.value'),
            ]);

            if (!$validator->fails()) {

                $setting_value_type = $request->input('setting_value_type');

                if($setting_value_type == 'text')
                {
                    $setting->update([
                        'setting_value_type' => $setting_value_type,
                        'value' => $request->input('value'),
                    ]);

                    ActionLogs::create([
                        'user_id' => $user->id,
                        'type' => get_class($setting),
                        'description' => $user->name. ' has EDITED value type to ' . $setting_value_type . ' with value ' . $request->input('value') . ' with id: '. $setting->id,
                    ]);
                }
                else
                {
                    $setting->update([
                        'setting_value_type' => $setting_value_type,
                        'value' => $request->input('date_value'),
                    ]);

                    ActionLogs::create([
                        'user_id' => $user->id,
                        'type' => get_class($setting),
                        'description' => $user->name. ' has EDITED value type to ' . $setting_value_type . ' with value ' . $request->input('date_value') . ' with id: '. $setting->id,
                    ]);
                }



                Alert::success(trans('public.done'), trans('public.successfully_updated_setting'));
                return redirect()->route('setting_listing');
            }

            $post = (object) $request->all();

        }

        return view('admin.setting.form', [
            'post' => $post,
            'setting' => $setting,
            'submit' => route('setting_edit', $id),
            'title' => 'Edit',
        ])->withErrors($validator);
    }

    public function setting_withdrawal(Request $request)
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

                $withdrawal_setting_type = $request->input('withdrawal_setting_type');
                $withdrawal_action = $request->input('withdrawal_action');

                if ($withdrawal_setting_type == 'personal') {

                    if ($withdrawal_action == User::ENABLE_WITHDRAWAL) {
                        $user->update([
                            'withdrawal_action' => 1
                        ]);

                        ActionLogs::create([
                            'user_id' => Auth::user()->id,
                            'type' => User::class,
                            'description' => 'Admin with id: '. Auth::user()->id .' has ENABLED WITHDRAWAL ACTION ON PERSONAL of USER ID: ' . $user->id,
                        ]);
                    } elseif ($withdrawal_action == User::DISABLE_WITHDRAWAL) {
                        $user->update([
                            'withdrawal_action' => 0
                        ]);

                        ActionLogs::create([
                            'user_id' => Auth::user()->id,
                            'type' => User::class,
                            'description' => 'Admin with id: '. Auth::user()->id .' has DISABLED WITHDRAWAL ACTION ON PERSONAL of USER ID: ' . $user->id,
                        ]);
                    }

                } elseif ($withdrawal_setting_type == 'group') {
                    $user_children_ids = $user->getChildrenIds();

                    if ($withdrawal_action == User::ENABLE_WITHDRAWAL) {
                        foreach ($user_children_ids as $user_children_id)
                        {
                            $children = User::find($user_children_id);

                            $user->update([
                                'withdrawal_action' => 1
                            ]);

                            ActionLogs::create([
                                'user_id' => Auth::user()->id,
                                'type' => User::class,
                                'description' => 'Admin with id: '. Auth::user()->id .' ENABLED WITHDRAWAL ACTION ON GROUP of USER ID: ' . $user->id,
                            ]);

                            $children->update([
                                'withdrawal_action' => 1
                            ]);

                            ActionLogs::create([
                                'user_id' => Auth::user()->id,
                                'type' => User::class,
                                'description' => 'Admin with id: '. Auth::user()->id .' ENABLED WITHDRAWAL ACTION ON GROUP of USER ID: ' . $children->id,
                            ]);
                        }
                    } elseif ($withdrawal_action == User::DISABLE_WITHDRAWAL) {
                        foreach ($user_children_ids as $user_children_id)
                        {
                            $children = User::find($user_children_id);

                            $user->update([
                                'withdrawal_action' => 0
                            ]);

                            ActionLogs::create([
                                'user_id' => Auth::user()->id,
                                'type' => User::class,
                                'description' => 'Admin with id: '. Auth::user()->id .' DISABLED WITHDRAWAL ACTION ON GROUP of USER ID: ' . $user->id,
                            ]);

                            $children->update([
                                'withdrawal_action' => 0
                            ]);

                            ActionLogs::create([
                                'user_id' => Auth::user()->id,
                                'type' => User::class,
                                'description' => 'Admin with id: '. Auth::user()->id .' DISABLED WITHDRAWAL ACTION ON GROUP of USER ID: ' . $children->id,
                            ]);
                        }
                    }

                } else {
                    Alert::success(trans('public.invalid_action'), trans('public.try_again'));
                    return redirect()->back();
                }

                Alert::success(trans('public.done'), trans('public.successfully_updated_withdrawal_setting'));
                return redirect()->back();
            }

            $post = (object) $request->all();

        }

        return view('admin.setting.setting_withdrawal', [
            'post' => $post,
            'users' => $users,
            'submit' => route('setting_withdrawal'),
            'title' => 'Withdrawal',
            'get_withdrawal_sel' => [User::ENABLE_WITHDRAWAL => trans('public.enable'), User::DISABLE_WITHDRAWAL => trans('public.disable')],
        ])->withErrors($validator);
    }

    public function setting_email_status(Request $request)
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

                $email_status_setting_type = $request->input('email_status_setting_type');
                $email_status = $request->input('email_status');

                if ($email_status_setting_type == 'personal') {

                    if ($email_status == User::ENABLE_WITHDRAWAL) {
                        $user->update([
                            'email_status' => 1
                        ]);

                        ActionLogs::create([
                            'user_id' => Auth::user()->id,
                            'type' => User::class,
                            'description' => 'Admin with id: '. Auth::user()->id .' ENABLED EMAIL STATUS ON PERSONAL of USER ID: ' . $user->id,
                        ]);
                    } elseif ($email_status == User::DISABLE_WITHDRAWAL) {
                        $user->update([
                            'email_status' => 0
                        ]);

                        ActionLogs::create([
                            'user_id' => Auth::user()->id,
                            'type' => User::class,
                            'description' => 'Admin with id: '. Auth::user()->id .' DISABLED EMAIL STATUS ON PERSONAL of USER ID: ' . $user->id,
                        ]);
                    }

                } elseif ($email_status_setting_type == 'group') {
                    $user_children_ids = $user->getChildrenIds();

                    if ($email_status == User::ENABLE_WITHDRAWAL) {
                        foreach ($user_children_ids as $user_children_id)
                        {
                            $children = User::find($user_children_id);

                            $user->update([
                                'email_status' => 1
                            ]);

                            ActionLogs::create([
                                'user_id' => Auth::user()->id,
                                'type' => User::class,
                                'description' => 'Admin with id: '. Auth::user()->id .' ENABLED EMAIL STATUS ON GROUP of USER ID: ' . $user->id,
                            ]);

                            $children->update([
                                'email_status' => 1
                            ]);

                            ActionLogs::create([
                                'user_id' => Auth::user()->id,
                                'type' => User::class,
                                'description' => 'Admin with id: '. Auth::user()->id .' ENABLED EMAIL STATUS ON GROUP of USER ID: ' . $children->id,
                            ]);
                        }
                    } elseif ($email_status == User::DISABLE_WITHDRAWAL) {
                        foreach ($user_children_ids as $user_children_id)
                        {
                            $children = User::find($user_children_id);

                            $user->update([
                                'email_status' => 0
                            ]);

                            ActionLogs::create([
                                'user_id' => Auth::user()->id,
                                'type' => User::class,
                                'description' => 'Admin with id: '. Auth::user()->id .'DISABLED EMAIL STATUS ON GROUP of USER ID: ' . $user->id,
                            ]);

                            $children->update([
                                'email_status' => 0
                            ]);

                            ActionLogs::create([
                                'user_id' => Auth::user()->id,
                                'type' => User::class,
                                'description' => 'Admin with id: '. Auth::user()->id .'DISABLED EMAIL STATUS ON GROUP of USER ID: ' . $children->id,
                            ]);
                        }
                    }

                } else {
                    Alert::success(trans('public.invalid_action'), trans('public.try_again'));
                    return redirect()->back();
                }

                Alert::success(trans('public.done'), trans('public.successfully_updated_email_status_setting'));
                return redirect()->back();
            }

            $post = (object) $request->all();

        }

        return view('admin.setting.email_status', [
            'post' => $post,
            'users' => $users,
            'submit' => route('setting_email_status'),
            'title' => 'Email Status',
            'get_withdrawal_sel' => [User::ENABLE_WITHDRAWAL => trans('public.enable'), User::DISABLE_WITHDRAWAL => trans('public.disable')],
        ])->withErrors($validator);
    }

    public function setting_lot_size(Request $request)
    {
        $validator = null;
        $post = null;

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'lot_size' => 'required|numeric'
            ])->setAttributeNames([
                'lot_size' => trans('public.lot_size')
            ]);

            if (!$validator->fails()) {

                Commissions::create([
                    'lot_size' => $request->lot_size,
                    'status' => 2,
                    'transaction_at' => now(),
                    'user_rankId' => 1,
                    'userId' => 1,
                    'brokersId' => 1,
                    'pamm_id' => 0,
                ]);

                ActionLogs::create([
                    'user_id' => Auth::id(),
                    'type' => Commissions::class,
                    'description' => Auth::user()->name. ' with id: ' . Auth::id() . ' has created one lot size.',
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_updated_setting'));
                return redirect()->back();
            }
            $post = (object) $request->all();
        }

        $records = Commissions::sortable()
            ->where('userId', 1)
            ->where('pamm_id', 0)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.setting.lot_size_setting', [
            'title' => 'Lot Size',
            'submit' => route('setting_lot_size'),
            'post' => $post,
            'records' => $records,
        ])->withErrors($validator);
    }
}
