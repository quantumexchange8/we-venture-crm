@extends('layouts.master-admin')

@section('title') {{ $title }} @lang('public.setting') @endsection

@section('contents')
    <div class="flex flex-row">
        <h1 class="flex-1 font-semibold text-2xl text-gray-500">@lang('public.setting') / @lang('public.update_setting')</h1>
        <a href="{{ route('setting_listing') }}" class="text-xl font-semibold text-[#3F83F8]">@lang('public.back')</a>
    </div>

    <form class="space-y-6 md:w-1/2 sm:w-full" action="{{ $submit }}" method="post">
        @csrf
        <div>
            <label for="title" class="block mb-6 font-bold text-[#3F83F8] dark:text-white">@lang('public.title')</label>
            <input type="text" name="title" id="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Setting Title" value="{{ ucfirst(str_replace('_', ' ', @$setting->name)) }}" disabled>
        </div>
        <p class="block font-bold text-[#3F83F8] dark:text-white">@lang('public.choose_value_type')</p>
        <div class="grid grid-cols-2 gap-4">
            <div class="flex items-center pl-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg">
                <input id="value_type" type="radio" value="date" name="setting_value_type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" @if($post->setting_value_type == 'date') checked @endif>
                <label for="value_type" class="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Date</label>
            </div>
            <div class="flex items-center pl-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg">
                <input id="value_type" type="radio" value="text" name="setting_value_type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" @if($post->setting_value_type == 'text') checked @endif>
                <label for="value_type" class="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Text</label>
            </div>
        </div>
        <p class="block font-bold text-[#3F83F8] dark:text-white date-value">@lang('public.date_value')</p>
        <div class="relative date-value">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
            </div>
            <input datepicker datepicker-format="yyyy-mm-dd" type="text" name="date_value" value="{{ @$post->value }}" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
        </div>

        <div class="text-value hidden">
            <label for="value" class="block mb-6 font-bold text-[#3F83F8] dark:text-white">@lang('public.value')</label>
            <input type="text" name="value" id="value" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white @error('value') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.value')" value="{{ @$post->value }}">
            @error('value')
            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="w-full text-white bg-[#4DA5FF] hover:bg-blue-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">@lang('public.update_setting')</button>
    </form>


@endsection

@section('script')
    <script>
        $(document).ready(function(e) {

            var type = $('input[name="setting_value_type"]:checked').val();
            setting_value_type_display();

            $('input[type=radio][name=setting_value_type]').change(function() {
                if (this.value == 'date') {
                    $('.date-value').show();
                    $('.text-value').hide();
                }
                else if (this.value == 'text') {
                    $('.date-value').hide();
                    $('.text-value').show();
                }
            })

            function setting_value_type_display() {
                if(type == 'text') {
                    $('.date-value').hide();
                    $('.text-value').show();
                } else if(type == 'date') {
                    $('.date-value').show();
                    $('.text-value').hide();
                }
            }
        });
    </script>
@endsection

