@extends('layouts.master-admin')

@section('title') {{ $title }} News @endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection

@section('contents')
    <div class="flex flex-row">
        <h1 class="flex-1 font-semibold text-2xl text-gray-500">@lang('public.news') / {{ $title == 'Add' ? trans('public.create_news') : trans('public.update_news') }}</h1>
        <a href="{{ route('news_listing') }}" class="text-xl font-semibold text-[#3F83F8]">@lang('public.back')</a>
    </div>

    <form class="space-y-6" action="{{ $submit }}" enctype="multipart/form-data" method="post">
        @csrf
        <div>
            <label for="title" class="block mb-2 font-bold text-[#3F83F8] dark:text-white">@lang('public.title')</label>
            <input type="text" name="title" id="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white @error('title') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="News Title" value="{{ @$post->title }}">
            @error('title')
            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="content" class="block mb-2 font-bold text-[#3F83F8] dark:text-white">@lang('public.description')</label>
            <textarea id="description" class="@error('content') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" name="content">{!! @$post->content !!}</textarea>
            @error('content')
            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <div>
            @if($title == 'Edit' && $news->hasMedia('news_image'))
                <div class="my-6 flex justify-center">
                    <figure class="max-w-lg">
                        <img class="h-auto max-w-full rounded-lg" src="{{ $news->getFirstMediaUrl('news_image') }}" alt="image description">
                    </figure>
                </div>
            @endif
            <label for="content" class="block mb-2 font-bold text-[#3F83F8] dark:text-white">@lang('public.news_image')</label>
            <div class="flex items-center justify-center w-full">
                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6" id="news_upload">
                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">@lang('public.click_upload')</span> @lang('public.or_drap_drop')</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">@lang('public.id_req')</p>
                    </div>
                    <input id="dropzone-file" type="file" class="hidden" name="news_image" accept="image/*" />
                </label>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label for="user" class="block font-bold text-[#3F83F8] dark:text-white">@lang('public.user') ({{ trans('public.not_visible') }})</label>
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
                <h4 class="block font-bold text-[#3F83F8] dark:text-white">@lang('public.action')</h4>
                <div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="visibility" value="on" class="sr-only peer" @if(@$post->visibility == 1) checked @endif>
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-[#3F83F8]"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">@lang('public.visible')</span>
                    </label>
                </div>
                <div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="popup_status" value="on" class="sr-only peer" @if(@$post->popup_status == 1) checked @endif>
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-[#3F83F8]"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">@lang('public.popup_status')</span>
                    </label>
                </div>
            </div>
        </div>

        @if($title == 'Add')
            <button type="submit" class="w-full text-white bg-[#3F83F8] hover:bg-blue-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">@lang('public.create_news')</button>
        @elseif($title = 'Edit')
            <button type="submit" class="w-full text-white bg-[#4DA5FF] hover:bg-blue-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">@lang('public.update_news')</button>
        @endif
    </form>


@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#description').summernote({
                placeholder: 'News Description Here..',
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

            $('.js-example-basic-multiple').select2();

            $("#dropzone-file").on("change", function() {
                $("#news_upload").html(`
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" />
            </svg>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">@lang('public.file_uploaded')</p>
        `);
            });
        });
    </script>
@endsection
