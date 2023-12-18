<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActionLogs;
use App\Models\Announcements;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Alert;
use Intervention\Image\Facades\Image;
use Session;

class NewsController extends Controller
{
    public function news_listing(Request $request)
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

        return view('admin.news.listing', [
            'news_all' => Announcements::get_record($search, 10),
            'search' =>  $search,
        ]);
    }

    public function create_news(Request $request)
    {
        $validator = null;
        $post = null;
        $users = User::query()
            ->where('status', User::STATUS_ACTIVE)
            ->where('role', User::ROLE_MEMBER)
            ->get();

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255',
                'content' => 'required',
                'news_image' => 'image',
            ])->setAttributeNames([
                'title' => trans('public.title'),
                'content' => trans('public.description'),
                'news_image' => trans('public.news_image'),
            ]);

            if (!$validator->fails()) {

                $news = Announcements::create([
                    'title' => $request->input('title'),
                    'content' => $request->input('content'),
                    'visibility' => $request->input('visibility') == 'on' ? 1 : 0,
                    'popup_status' => $request->input('popup_status') == 'on' ? 1 : 0,
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

                    $news->update([
                        'selected_users' => array_map('intval', $request->input('user')),
                        'user_ids' => json_encode($userAllowToView)
                    ]);
                }

                if ($request->hasFile('news_image')) {
                    $news->addMedia($request->news_image)->toMediaCollection('news_image');
                }

                ActionLogs::create([
                    'user_id' => Auth::user()->id,
                    'type' => Announcements::class,
                    'description' => 'Admin with id: '. Auth::user()->id .' has CREATED news of ID: ' . $news->id,
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_added_news'));
                return redirect()->route('news_listing');
            }

            $post = (object) $request->all();

        }

        return view('admin.news.form', [
            'post' => $post,
            'title' => 'Add',
            'submit' => route('create_news'),
            'users' => $users,
        ])->withErrors($validator);
    }

    public function news_edit(Request $request, $id)
    {
        $validator = null;
        $post = $news = Announcements::find($id);
        $users = User::query()
            ->where('status', User::STATUS_ACTIVE)
            ->where('role', User::ROLE_MEMBER)
            ->get();

        if (!$news) {
            Alert::error(trans('public.invalid_news'), trans('public.try_again'));
            return redirect()->back();
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'content' => 'required',
                'news_image' => 'image',
            ])->setAttributeNames([
                'title' => trans('public.title'),
                'content' => trans('public.description'),
                'news_image' => trans('public.news_image'),
            ]);

            if (!$validator->fails()) {

                $news->update([
                    'title' => $request->input('title'),
                    'content' => $request->input('content'),
                    'visibility' => $request->input('visibility') == 'on' ? 1 : 0,
                    'popup_status' => $request->input('popup_status') == 'on' ? 1 : 0,
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

                    $news->update([
                        'selected_users' => array_map('intval', $request->input('user')),
                        'user_ids' => json_encode($userAllowToView)
                    ]);
                }

                if ($request->hasFile('news_image')) {
                    $news->clearMediaCollection('news_image');
                    $news->addMedia($request->news_image)->toMediaCollection('news_image');
                }

                ActionLogs::create([
                    'user_id' => Auth::user()->id,
                    'type' => Announcements::class,
                    'description' => 'Admin with id: '. Auth::user()->id .' has UPDATED news of ID: ' . $news->id,
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_updated_news'));
                return redirect()->route('news_listing');
            }

            $post = (object) $request->all();

        }

        return view('admin.news.form', [
            'post' => $post,
            'news' => $news,
            'submit' => route('news_edit', $id),
            'title' => 'Edit',
            'users' => $users,
        ])->withErrors($validator);
    }

    public function delete(Request $request)
    {
        $news_id = $request->input('news_id');
        $news = Announcements::find($news_id);

        if (!$news) {
            Alert::error(trans('public.invalid_news'), trans('public.try_again'));
            return redirect()->route('news_listing');
        }

        $news->update([
            'deleted_at' => now()
        ]);

        ActionLogs::create([
            'user_id' => Auth::user()->id,
            'type' => Announcements::class,
            'description' => 'Admin with id: '. Auth::user()->id .' has DELETED news of ID: ' . $news->id,
        ]);

        Alert::success(trans('public.done'), trans('public.successfully_deleted_news'));
        return redirect()->route('news_listing');
    }
}
