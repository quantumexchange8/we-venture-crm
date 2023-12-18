<?php

namespace App\Http\Controllers\Web\Admin;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\Pamm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PammController extends Controller
{
    public function listing(Request $request)
    {
        $pamms = Pamm::where('status', Pamm::STATUS_ACTIVE)->paginate(10);

        return view('admin.pamm.listing', [
            'pamms' => $pamms,
        ]);
    }

    public function pamm_add(Request $request)
    {
        $validator = null;
        $post = null;

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'code' => 'required',
            ])->setAttributeNames([
                'name' => trans('public.name'),
                'code' => trans('public.code'),
            ]);

            if (!$validator->fails()) {

                Pamm::create([
                    'name' => $request->name,
                    'code' => $request->code,
                    'status' => $request->status == 'on' ? 1 : 0,
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_added_pamm'));
                return redirect()->route('pamm_listing');
            }

            $post = (object) $request->all();

        }

        return view('admin.pamm.form', [
            'post' => $post,
            'submit' => route('pamm_add'),
            'title' => 'Add',
        ])->withErrors($validator);
    }

    public function pamm_edit(Request $request, $id)
    {
        $validator = null;
        $post = $pamm = Pamm::find($id);

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'code' => 'required',
            ])->setAttributeNames([
                'name' => trans('public.name'),
                'code' => trans('public.code'),
            ]);

            if (!$validator->fails()) {

                $pamm->update([
                    'name' => $request->name,
                    'code' => $request->code,
                    'status' => $request->status == 'on' ? 1 : 0,
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_updated_pamm'));
                return redirect()->route('pamm_listing');
            }

            $post = (object) $request->all();

        }

        return view('admin.pamm.form', [
            'post' => $post,
            'pamm' => $pamm,
            'submit' => route('pamm_edit', $id),
            'title' => 'Edit',
        ])->withErrors($validator);
    }

    public function pamm_delete(Request $request)
    {
        $pamm_id = $request->input('pamm_id');
        $pamm = Pamm::find($pamm_id);

        if (!$pamm) {
            Alert::error(trans('public.invalid_action'), trans('public.try_again'));
            return redirect()->route('pamm_listing');
        }

        $pamm->update([
            'deleted_at' => now()
        ]);

        Alert::success(trans('public.done'), trans('public.successfully_deleted_pamm'));
        return redirect()->route('pamm_listing');
    }
}
