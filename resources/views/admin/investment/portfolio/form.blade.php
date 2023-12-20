@extends('layouts.master-admin')

@section('title') Investment {{ $title }} @endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection

@section('contents')

    <div class="flex flex-row">
        <h1 class="flex-1 font-semibold text-2xl text-gray-500">@lang('public.investment') / {{ ($title)== 'Add' ? trans('public.add_portfolio') : trans('public.update_portfolio') }} </h1>
        <a href="{{ route('portfolio_listing') }}" class="text-xl font-semibold text-[#3F83F8]">@lang('public.back')</a>
    </div>
    <div class="bg-white rounded shadow-lg p-6">
        <form action="{{ $submit }}" method="post">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 w-full gap-6">
                <div class="col-span-2">
                    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                            @foreach(config('translatable.locales') as $locale)
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="{{ $locale }}-tab" data-tabs-target="#{{ $locale }}" type="button" role="tab" aria-controls="{{ $locale }}" aria-selected="false">@lang('public.'.$locale )</button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div id="myTabContent">
                        @foreach(config('translatable.locales') as $locale)
                            <div class="tab-content hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="{{ $locale }}" role="tabpanel" aria-labelledby="{{ $locale }}-tab">
                                <div class="mb-6">
                                    <label for="name[{{ $locale }}]" class="block mb-2 font-bold text-[#3F83F8] dark:text-white">@lang('public.title') ( @lang('public.'.$locale ) )</label>
                                    <input type="text" id="name[{{ $locale }}]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error($locale.'.name') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.title') ( @lang('public.'.$locale ) )" name="{{ $locale }}[name]"
                                           @if($title == 'Add')
                                               value="{{ @$post->$locale['name'] }}"
                                           @else
                                               value="{{ @$post->translate($locale)->name }}"
                                        @endif
                                    >
                                    @error($locale.'.name')
                                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-6">
                                    <label for="description-{{ $locale }}" class="block mb-2 font-bold text-[#3F83F8] dark:text-white">@lang('public.description') ( @lang('public.'.$locale ) )</label>

                                    <textarea id="description-{{ $locale }}" class="summernote" name="{{ $locale }}[description]">@if($title == 'Add'){!! @$post->$locale['description'] !!}@else{!! @$post->translate($locale)->description !!}@endif</textarea>
                                    @error($locale.'.description')
                                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="mt-12 space-y-6">
                    <div class="space-y-2">
                        <label for="min_amount" class="block mb-2 font-bold text-[#3F83F8] dark:text-white">@lang('public.min_amount')</label>
                        <input type="number" step=".01" id="min_amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('min_amount') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="0.00" name="min_amount" value="{{ @$post->min_amount }}"
                        >
                        @error('min_amount')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="user" class="block font-bold text-[#3F83F8] dark:text-white">@lang('public.user')</label>
                        <select class="js-example-basic-multiple w-full" id="user" name="user[]" multiple="multiple">
                            @foreach($users as $user)
                                <option @if(in_array($user->id, old('user', json_decode(@$post->selected_users) ?? []))) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="status" class="block mb-2 font-bold text-[#3F83F8] dark:text-white">@lang('public.status')</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="status" value="active" class="sr-only peer" @if(@$post->status == 'active') checked @endif>
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-[#3F83F8]"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">@lang('public.active')</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="mt-6">
                @if($title == 'Add')
                    <button type="submit" class="text-white bg-[#40DD7F] hover:bg-[#40DD7F]/90 focus:ring-4 focus:outline-none focus:ring-[#40DD7F]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#40DD7F]/55 mb-2">
                        <svg class="h-6 w-6 text-white"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="ml-2">@lang('public.add_portfolio')</span>
                    </button>
                @elseif($title == 'Edit')
                    <button type="submit" class="text-white bg-[#1A8BFF] hover:bg-[#1A8BFF]/90 focus:ring-4 focus:outline-none focus:ring-[#1A8BFF]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#1A8BFF]/55 mr-2 mb-2">
                        <svg class="h-6 w-6 text-white"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="ml-2">@lang('public.update_portfolio')</span>
                    </button>
                @endif
            </div>
        </form>
    </div>

@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function(e){
            $('.summernote').each(function() {
                const locale = $(this).attr('id').split('-')[1]; // Extract locale from the ID
                $(this).summernote({
                    placeholder: 'Portfolio Description Here..',
                    tabsize: 2,
                    height: 200,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
            });

            $('.js-example-basic-multiple').select2();
        });
    </script>
@endsection
