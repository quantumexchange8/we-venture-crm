<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActionLogs;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Alert;

class EventController extends Controller
{
    private $path_url = 'uploads/events';

    public function listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['news_search' => [
                        'freetext' =>  $request->input('freetext'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('news_search');
                    break;
            }
        }

        $search = session('news_search') ? session('news_search') : $search;

        return view('admin.event.listing', [
            'events' => Event::get_record($search, 10),
            'search' =>  $search,
        ]);
    }

    public function create_event(Request $request)
    {
        $validator = null;
        $post = null;
        $users = User::query()
            ->where('status', User::STATUS_ACTIVE)
            ->where('role', User::ROLE_MEMBER)
            ->get();

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'event_title' => 'required|max:255',
                'event_image' => 'required|max:5120',
            ])->setAttributeNames([
                'event_title' => trans('public.event_title'),
                'event_image' => trans('public.event_image'),
            ]);

            if (!$validator->fails()) {

                $event = Event::create([
                    'event_title' => $request->input('event_title'),
                    'visibility' => $request->input('visibility') == 'on' ? 1 : 0,
                    'pop_up_status' => $request->input('pop_up_status') == 'on' ? 1 : 0,
                    'user_id' => Auth::user()->id,
                ]);

                if ($request->user) {
                    $user_ids = is_array($request->user) ? $request->user : [];

                    $userAllowToView = [];
                    foreach ($user_ids as $user_id) {
                        $user = User::find($user_id);

                        if ($user) {
                            $userChildrenIds = $user->getChildrenIds();
                            $userAllowToView = array_merge($userAllowToView, $userChildrenIds, [intval($user_id)]);
                        }
                    }

                    $event->update([
                        'selected_users' => array_map('intval', $request->input('user')),
                        'user_ids' => json_encode($userAllowToView)
                    ]);
                }

                if ($request->hasFile('event_image')) {
                    $images = $request->event_image;
                    foreach ($images as $image) {
                        $event->addMedia($image)->toMediaCollection('event_images');
                    }
                }

                ActionLogs::create([
                    'user_id' => Auth::user()->id,
                    'type' => Event::class,
                    'description' => 'Admin with id: '. Auth::user()->id .' has CREATED new event of ID: ' . $event->id,
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_added_event'));
                return redirect()->route('event_listing');
            }

            $post = (object) $request->all();

        }

        return view('admin.event.form', [
            'post' => $post,
            'title' => 'Add',
            'submit' => route('create_event'),
            'users' => $users
        ])->withErrors($validator);
    }

    public function event_edit(Request $request, $id)
    {
        $validator = null;
        $post = $event = Event::find($id);
        $users = User::query()
            ->where('status', User::STATUS_ACTIVE)
            ->where('role', User::ROLE_MEMBER)
            ->get();

        if (!$event) {
            Alert::error(trans('public.invalid_event'), trans('public.try_again'));
            return redirect()->back();
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'event_title' => 'required|max:255',
                'event_image' => 'max:5120',
            ])->setAttributeNames([
                'event_title' => trans('public.event_title'),
                'event_image' => trans('public.event_image'),
            ]);

            if (!$validator->fails()) {

                $event->update([
                    'event_title' => $request->input('event_title'),
                    'visibility' => $request->input('visibility') == 'on' ? 1 : 0,
                    'pop_up_status' => $request->input('pop_up_status') == 'on' ? 1 : 0,
                    'userId' => Auth::user()->id,
                ]);

                if ($request->user) {
                    $user_ids = is_array($request->user) ? $request->user : [];

                    $userAllowToView = [];
                    foreach ($user_ids as $user_id) {
                        $user = User::find($user_id);

                        if ($user) {
                            $userChildrenIds = $user->getChildrenIds();
                            $userAllowToView = array_merge($userAllowToView, $userChildrenIds, [intval($user_id)]);
                        }
                    }

                    $event->update([
                        'selected_users' => array_map('intval', $request->input('user')),
                        'user_ids' => json_encode($userAllowToView)
                    ]);
                }

                if ($request->hasFile('event_image')) {
                    $event->clearMediaCollection('event_images');
                    $images = $request->event_image;
                    foreach ($images as $image) {
                        $event->addMedia($image)->toMediaCollection('event_images');
                    }
                }

                ActionLogs::create([
                    'user_id' => Auth::user()->id,
                    'type' => Event::class,
                    'description' => 'Admin with id: '. Auth::user()->id .' has UPDATED event of ID: ' . $event->id,
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_updated_event'));
                return redirect()->route('event_listing');
            }

            $post = (object) $request->all();

        }

        return view('admin.event.form', [
            'post' => $post,
            'event' => $event,
            'submit' => route('event_edit', $id),
            'title' => 'Edit',
            'users' => $users
        ])->withErrors($validator);
    }

    public function delete(Request $request)
    {
        $event_id = $request->input('event_id');
        $event = Event::find($event_id);

        if (!$event) {
            Alert::error(trans('public.invalid_event'), trans('public.try_again'));
            return redirect()->route('event_listing');
        }

        $event->update([
            'deleted_at' => now()
        ]);

        ActionLogs::create([
            'user_id' => Auth::user()->id,
            'type' => Event::class,
            'description' => 'Admin with id: '. Auth::user()->id .' has DELETED event of ID: ' . $event->id,
        ]);

        Alert::success(trans('public.done'), trans('public.successfully_deleted_event'));
        return redirect()->route('event_listing');
    }
}
