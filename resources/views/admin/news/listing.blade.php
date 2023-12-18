@extends('layouts.master-admin')

@section('title') News @endsection

@section('contents')
    <h1 class="font-semibold text-2xl text-gray-500">@lang('public.news')</h1>

    <!-- search -->
    <div class="flex flex-col">
        <form method="post" action="{{ route('news_listing') }}">
            @csrf
            <div class="grid gap-6 mb-6 mt-4 md:grid-cols-1">
                <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">@lang('public.search')</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" id="search" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-blue-500" placeholder="@lang('public.search_name')" name="freetext" value="{{ @$search['freetext'] }}">
                </div>
                <div class="max-[755px]:flex max-[755px]:flex-col gap-2">
                    <button type="submit" class="text-white bg-primary hover:bg-primary-600 border border-primary-200 focus:ring-4 focus:outline-none focus:ring-primary-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" name="submit" value="search">@lang('public.search')</button>
                    <button type="submit" class="text-white bg-rose-500 hover:bg-rose-600 border border-rose-200 focus:ring-4 focus:outline-none focus:ring-rose-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-rose-600 dark:hover:bg-rose-700 dark:focus:ring-rose-800" name="submit" value="reset">@lang('public.reset')</button>
                    <a href="{{ route('create_news') }}" class="inline-flex text-white py-1.5 px-8 rounded bg-[#2AC769] hover:bg-success-500 text-lg font-bold float-right items-center justify-center">
                        <div class="flex items-center">
                            <svg class="h-6 w-6 text-white"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span class="ml-4 text-md font-bold">@lang('public.create_news')</span>
                        </div>
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if($news_all->isNotEmpty())
        <div class="relative overflow-x-auto mt-2 text-sm">
            <table class="w-full text-black text-left dark:text-gray-400 table-auto">
                <thead class="uppercase bg-[#F6F6F6]">
                <tr>
                    <th class="px-6 py-3 text-md font-bold" style="width: 20%">
                        @lang('public.date_created')
                    </th>
                    <th  class="px-6 py-3 text-md font-bold">
                        @lang('public.news_title')
                    </th>
                    <th  class="px-6 py-3 text-md font-bold" style="width: 12%">
                        @lang('public.visibility')
                    </th>
                    <th  class="px-6 py-3 text-md font-bold w-12">
                        @lang('public.action')
                    </th>
                </tr>
                </thead>
                <tbody>
                    @foreach($news_all as $news)
                        <tr class="border-b odd:bg-[#FDFCF3] even:bg-[#F6F6F6]">
                            <td class="px-6 py-4 ">
                                {{ $news->created_at }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $news->title }}
                            </td>
                            <td class="px-6 py-4">
                                @if($news->visibility == 1)
                                    <span class="font-semibold text-success">@lang('public.visible')</span>
                                @else
                                    <span class="font-semibold text-danger">@lang('public.not_visible')</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="javascript:void(0)" class="text-gray-700" data-te-toggle="modal"
                                       data-te-target="#newsModal-{{ $news->id }}"
                                       data-te-ripple-init
                                       data-te-ripple-color="light">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 hover:fill-gray-400">
                                            <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                            <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    @include('admin.news.view_modal')
                                    <a href="{{ route('news_edit', $news->id) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 fill-primary hover:fill-primary-400">
                                            <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                        </svg>
                                    </a>
                                    <a href="javascript:void(0)" class="delete"
                                       data-modal-target="delete_modal" data-modal-toggle="delete_modal"
                                       data-te-ripple-init
                                       data-te-ripple-color="light" id="{{ $news->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 fill-danger hover:fill-danger-400">
                                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="my-4">
                {!! $news_all->links('pagination::tailwind') !!}
            </div>
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
                    <form method="POST" action="{{ route('news_delete') }}">
                        @csrf
                        <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="modal-body">
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">@lang('public.delete_news_confirmation')</h3>
                            <input type="hidden" name="news_id" id="news_id">
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
                $(".modal-body #news_id").val( id );
            });
        });
    </script>

@endsection
