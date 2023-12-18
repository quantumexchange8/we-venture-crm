@extends('layouts.master-admin')

@section('title') Brokers {{ $title }} @endsection

@section('contents')
    <h1 class="font-semibold text-2xl text-gray-500">@lang('public.brokers')</h1>

    <!-- search -->
    <div class="flex flex-col">
        <form method="post" action="{{ route('broker_listing') }}">
            @csrf
            <div class="grid gap-6 mb-6 mt-4 md:grid-cols-1">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" id="search" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-blue-500" placeholder="@lang('public.search_name')" name="freetext" value="{{ @$search['freetext'] }}">
                </div>
                <div class="max-[755px]:flex max-[755px]:flex-col gap-2">
                    <button type="submit" class="text-white bg-primary hover:bg-primary-600 border border-primary-200 focus:ring-4 focus:outline-none focus:ring-primary-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" name="submit" value="search">@lang('public.search')</button>
                    <button type="submit" class="text-white bg-rose-500 hover:bg-rose-600 border border-rose-200 focus:ring-4 focus:outline-none focus:ring-rose-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-rose-600 dark:hover:bg-rose-700 dark:focus:ring-rose-800" name="submit" value="reset">@lang('public.reset')</button>
                    <a href="{{ route('broker_add') }}" class="inline-flex text-white py-1.5 px-8 rounded bg-[#2AC769] hover:bg-success-500 text-lg font-bold float-right items-center justify-center">
                        <div class="flex items-center">
                            <svg class="h-6 w-6 text-white"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span class="ml-4 text-md font-bold">@lang('public.add_broker')</span>
                        </div>
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if($records->isNotEmpty())
        <div class="grid grid-cols-2 gap-6 my-4 max-[1100px]:grid-rows-auto max-[1450px]:grid-cols-1 max-[1100px]:grid-cols-1">
        @foreach($records as $record)
            <div class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 mb-4">
{{--                @dd($record->broker_image)--}}
                <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-l-lg" src="{{ asset('uploads/brokers/' .$record->broker_image)}}" alt="">
                <div class="flex flex-col justify-between p-4 leading-normal">
                    <p class="mb-2 text-xs text-gray-500">@lang('public.last_updated') {{ $record->updated_at }}</p>
                    <p class="mb-3 text-2xl font-bold text-[#FFA168]">
                        {{ $record->name }}
                    </p>
                    <div>
                        <a href="{{ route('broker_edit', $record->id) }}" class="text-sm text-[#23A6F0] font-semibold">@lang('public.edit') </a>
                        <a href="javascript:void(0)" class="text-sm text-[#E93C3C] font-semibold ml-2 delete"
                           data-modal-target="delete_modal" data-modal-toggle="delete_modal"
                           data-te-ripple-init
                           data-te-ripple-color="light" id="{{ $record->id }}">
                            @lang('public.remove')
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @else
        <div class="flex p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">@lang('public.info')</span>
            <div>
                <span class="font-medium">@lang('public.info') :</span>@lang('public.no_record')
            </div>
        </div>
    @endif

    <!-- Delete Modal -->
    <div id="delete_modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="delete_modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">@lang('public.close_modal')</span>
                </button>
                <div class="p-6 text-center">
                    <form method="POST" action="{{ route('broker_delete') }}">
                        @csrf
                        <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="modal-body">
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">@lang('public.delete_broker_confirmation')</h3>
                            <input type="hidden" name="broker_id" id="broker_id">
                        </div>
                        <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            @lang('public.delete_confirmed')
                        </button>
                        <button data-modal-hide="delete_modal" type="button" class="text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">@lang('public.delete_cancel')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
        $(document).ready(function(e) {
            $('.delete').on('click', function() {
                var id = $(this).attr('id');
                $(".modal-body #broker_id").val( id );
            });
        });
    </script>
@endsection
