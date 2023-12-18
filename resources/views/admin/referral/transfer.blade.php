@extends('layouts.master-admin')

@section('title') Referrals-{{ $title }} @endsection

@section('css')
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet" />
@endsection

@section('contents')
    <h1 class="font-semibold text-2xl text-gray-500 mb-2">@lang('public.referrals') / @lang('public.network_transfer')</h1>
    <p class="text-sm text-gray-400">@lang('public.transfer_message')</p>
    @if($errors->any())
        @foreach($errors->all() as $key => $error)
            <div id="toast-danger-{{ $key }}" class="absolute top-30 right-10 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">@lang('public.error_icon')</span>
                </div>
                <div class="ml-3 font-normal">{{ $error }}</div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-danger-{{ $key }}" aria-label="Close">
                    <span class="sr-only">@lang('public.close')</span>
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
        @endforeach
    @endif
    <form class="mt-6" action="{{ route('referral_transfer') }}" method="post">
        @csrf
        <div class="flex gap-12">
            <div class="w-full max-w-sm p-4 bg-[#FDFCF3] border border-gray-200 rounded-lg shadow sm:p-6 dark:bg-gray-800 dark:border-gray-700 flex-1">
                <h5 class="mb-3 text-base font-semibold text-[#FFA168] md:text-xl dark:text-white">
                    @lang('public.choose_customer')
                </h5>
                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">@lang('public.search_choose_transfer')</p>
                <div class="mt-6">
                    <select class="js-example-basic-single w-full" name="user">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->email }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="w-full max-w-sm p-4 bg-[#FDFCF3] border border-gray-200 rounded-lg shadow sm:p-6 dark:bg-gray-800 dark:border-gray-700 flex-1">
                <h5 class="mb-3 text-base font-semibold text-[#FFA168] md:text-xl dark:text-white">
                    @lang('public.choose_customer')
                </h5>
                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">@lang('public.search_choose_transfer')</p>
                <div class="mt-6">
                    <select class="js-example-basic-single w-full" name="parent">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->email }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="text-white bg-[#40DD7F] hover:bg-success-400 focus:ring-4 focus:outline-none focus:ring-success-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-success-600 dark:hover:bg-success-700 dark:focus:ring-success-800">@lang('public.confirm_transfer')</button>
        </div>
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
