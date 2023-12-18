<?php

namespace App\Http\Controllers\Web\Admin;

use App\Exports\InvestmentsExport;
use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\Portfolio;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Alert;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class InvestmentController extends Controller
{
    public function portfolio_listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['broker_search' => [
                        'freetext' =>  $request->input('freetext'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('broker_search');
                    break;
            }
        }

        $search = session('broker_search') ? session('broker_search') : $search;


        $posts = Portfolio::translatedIn(app()->getLocale())
            ->latest()
            ->take(10)
            ->get();

        return view('admin.investment.portfolio.listing', [
            'title' => 'Listing',
            'records' => Portfolio::get_record($search, 10),
            'posts' => $posts,
            'search' =>  $search,
        ]);
    }

    public function add_portfolio(Request $request)
    {
        $validator = null;
        $post = null;
        $languages = config('translatable.locales');
        $rules = [];
        $users = User::query()
            ->where('status', User::STATUS_ACTIVE)
            ->where('role', User::ROLE_MEMBER)
            ->get();

        if ($request->isMethod('post')) {

            $attributeNames = [
                'min_amount' => trans('public.min_amount'),
                'user' => trans('public.user'),
            ];

            foreach ($languages as $lang) {
                $rules["{$lang}.name"] = 'required';
                $rules["{$lang}.description"] = 'required';

                $attributeNames["{$lang}.name"] = trans('public.title').' ('.trans("public.{$lang}").')';
                $attributeNames["{$lang}.description"] = trans('public.description').' ('.trans("public.{$lang}").')';
            }

            $validator = Validator::make($request->all(), $rules+[
                'min_amount' => 'required|numeric',
                'user' => 'required',
                ])->setAttributeNames($attributeNames);

            if (!$validator->fails())
            {
                $portfolio_data = [];

                foreach ($languages as $lang) {
                    $name_key = $lang . '.name';
                    $description_key = $lang . '.description';

                    // Build an array for the portfolio data
                    $portfolio_data[$lang] = [
                        'name' => $request->input($name_key),
                        'description' => $request->input($description_key),
                    ];
                }

                $user_ids = is_array($request->user) ? $request->user : [];

                $userAllowToView = [];
                foreach ($user_ids as $user_id) {
                    $user = User::find($user_id);

                    if ($user) {
                        $userChildrenIds = $user->getChildrenIds();
                        $userAllowToView = array_merge($userAllowToView, $userChildrenIds, [intval($user_id)]);
                    }
                }

                $portfolio = Portfolio::create($portfolio_data + [
                    'min_amount' => $request->min_amount,
                    'status' => $request->input('status') == 'active' ? 'active' : 'inactive',
                ]);

                $portfolio->update([
                    'selected_users' => array_map('intval', $request->input('user')),
                    'user_ids' => json_encode($userAllowToView)
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_added_portfolio'));

                return redirect()->route('portfolio_listing');
            }
            $post = (object) $request->all();
        }

        return view('admin.investment.portfolio.form', [
            'title' => 'Add',
            'submit' => route('add_portfolio'),
            'post' => $post,
            'users' => $users,
        ])->withErrors($validator);
    }

    public function portfolio_edit(Request $request, $id)
    {
        $validator = null;
        $post = $portfolio = Portfolio::find($id);
        $languages = config('translatable.locales');
        $rules = [];
        $users = User::query()
            ->where('status', User::STATUS_ACTIVE)
            ->where('role', User::ROLE_MEMBER)
            ->get();

        if (!$portfolio) {
            Alert::error(trans('public.invalid_action'), trans('public.try_again'));
            return redirect()->back();
        }

        if ($request->isMethod('post')) {

            $attributeNames = [
                'min_amount' => trans('public.min_amount'),
            ];

            foreach ($languages as $lang) {
                $rules["{$lang}.name"] = 'required';
                $rules["{$lang}.description"] = 'required';

                $attributeNames["{$lang}.name"] = trans('public.name').' ('.trans("public.{$lang}").')';
                $attributeNames["{$lang}.description"] = trans('public.description').' ('.trans("public.{$lang}").')';
            }

            $validator = Validator::make($request->all(), $rules+[
                    'min_amount' => 'required|numeric',
                ])->setAttributeNames($attributeNames);

            if (!$validator->fails()) {

                $portfolio_data = [];

                foreach ($languages as $lang) {
                    $name_key = $lang . '.name';
                    $description_key = $lang . '.description';

                    $portfolio_data[$lang] = [
                        'name' => $request->input($name_key),
                        'description' => $request->input($description_key),
                    ];
                }

                $user_ids = is_array($request->user) ? $request->user : [];

                $userAllowToView = [];
                foreach ($user_ids as $user_id) {
                    $user = User::find($user_id);

                    if ($user) {
                        $userChildrenIds = $user->getChildrenIds();
                        $userAllowToView = array_merge($userAllowToView, $userChildrenIds, [intval($user_id)]);
                    }
                }

                $portfolio->update($portfolio_data+[
                        'min_amount' => $request->input('min_amount'),
                        'status' => $request->input('status') == 'active' ? 'active' : 'inactive',
                        'selected_users' => array_map('intval', $request->input('user')),
                        'user_ids' => json_encode($userAllowToView)
                    ]);

                Alert::success(trans('public.done'), trans('public.successfully_updated_portfolio'));
                return redirect()->route('portfolio_listing');
            }

            $post = (object) $request->all();
        }

        return view('admin.investment.portfolio.form', [
            'title' => 'Edit',
            'submit' => route('portfolio_edit', $id),
            'portfolio' => $portfolio,
            'post' => $post,
            'users' => $users,
        ])->withErrors($validator);
    }

    public function portfolio_delete(Request $request)
    {
        $portfolio_id = $request->input('portfolio_id');
        $portfolio = Portfolio::find($portfolio_id);

        if (!$portfolio) {
            Alert::error(trans('public.invalid_broker'), trans('public.try_again'));
            return redirect('broker_listing');
        }

        $portfolio->delete();

        Alert::success(trans('public.done'), trans('public.successfully_deleted_portfolio'));
        return redirect()->route('portfolio_listing');
    }

    public function investment_listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['admin_investment_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'created_start' => $request->input('created_start'),
                        'created_end' => $request->input('created_end'),
                        'filter_status' => $request->input('filter_status'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new InvestmentsExport( Investment::get_records(session('admin_investment_search'))), $now . '-investments-records.xlsx');
                case 'reset':
                    session()->forget('admin_investment_search');
                    break;
            }
        }

        $search = session('admin_investment_search') ? session('admin_investment_search') : $search;
        return view('admin.investment.listing', [
            'title' => 'Investment Listing',
            'submit' => route('investment_listing'),
            'records' => Investment::get_records($search)->paginate(10),
            'search' =>  $search,
            'get_status_sel' =>  ['processing' => trans('public.processing'), 'approved' => trans('public.approved'), 'rejected' => trans('public.rejected')],
        ]);
    }

    public function investment_approval(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in(['approve', 'reject'])],
        ]);

        $approval = $request->input('status');
        $investment = Investment::find($id);

        if (!$investment) {
            Alert::error(trans('public.invalid_action'), trans('public.invalid_status'));
            return back();
        }

        switch ($approval) {
            case 'approve':
                $investment->update([
                    'status' => 'approved',
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_approved_deposit'));
                break;

            case 'reject':
                $investment->update([
                    'status' => 'rejected',
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_rejected_deposit'));
                break;
        }

        return back();
    }
}
