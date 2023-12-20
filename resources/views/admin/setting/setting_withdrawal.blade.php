@extends('layouts.master-admin')

@section('title') {{ $title }} Setting @endsection

@section('css')
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet" />
@endsection

@section('contents')
    <div class="flex flex-row">
        <h1 class="flex-1 font-semibold text-2xl text-gray-500">@lang('public.setting') / @lang('public.withdrawal_action')</h1>
        <a href="{{ route('setting_listing') }}" class="text-xl font-semibold text-[#3F83F8]">@lang('public.back')</a>
    </div>

    <form class="space-y-6 md:w-1/2 sm:w-full" action="{{ $submit }}" method="post">
        @csrf
        <p class="block font-bold text-[#3F83F8] dark:text-white">@lang('public.choose_type')</p>
        <ul class="grid w-full gap-6 md:grid-cols-2">
            <li>
                <input type="radio" id="hosting-small" name="withdrawal_setting_type" value="personal" class="hidden peer" checked>
                <label for="hosting-small" class="inline-flex items-center justify-between w-full px-3 py-1 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-400 peer-checked:text-blue-400 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <div class="block">
                        <div class="w-full text-lg font-semibold">@lang('public.personal')</div>
                        <div class="w-full">@lang('public.specific_user')</div>
                    </div>
                    <svg aria-hidden="true" class="w-6 h-6 ml-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </label>
            </li>
            <li>
                <input type="radio" id="hosting-big" name="withdrawal_setting_type" value="group" class="hidden peer">
                <label for="hosting-big" class="inline-flex items-center justify-between w-full px-3 py-1 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-400 peer-checked:text-blue-400 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                    <div class="block">
                        <div class="w-full text-lg font-semibold">@lang('public.group')</div>
                        <div class="w-full">@lang('public.with_children')</div>
                    </div>
                    <svg aria-hidden="true" class="w-6 h-6 ml-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </label>
            </li>
        </ul>
        <div class="text-value">
            <label for="user" class="block mb-6 font-bold text-[#3F83F8] dark:text-white">@lang('public.user')</label>
            <select class="js-example-basic-single w-full max-w-sm" id="user" name="user">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <label for="countries" class="block mb-6 font-bold text-[#3F83F8] dark:text-white">@lang('public.select_action')</label>
        {!! Form::select('withdrawal_action', $get_withdrawal_sel, @$post['withdrawal_action'], ['class' => 'font-medium text-sm max-w-sm placeholder:text-gray-400 text-gray-500 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']) !!}



        <button type="submit" class="w-full text-white bg-[#4DA5FF] hover:bg-blue-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">@lang('public.update_setting')</button>
    </form>


@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function(e){
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection

