@extends('layouts.master-admin')

@section('title') {{ $title }} PAMM @endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection

@section('contents')
    <div class="flex flex-row">
        <h1 class="flex-1 font-semibold text-2xl text-gray-500">@lang('public.pamm') / {{ $title == 'Add' ? trans('public.add_pamm') : trans('public.update_pamm') }}</h1>
        <a href="{{ route('pamm_listing') }}" class="text-xl font-semibold text-[#FFA168]">@lang('public.back')</a>
    </div>

    <form class="space-y-6" action="{{ $submit }}" enctype="multipart/form-data" method="post">
        @csrf
        <div>
            <label for="code" class="block mb-2 font-bold text-[#FFA168] dark:text-white">@lang('public.code')</label>
            <input type="text" name="code" id="code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white @error('code') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.code')" value="{{ @$post->code }}">
            @error('code')
            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="name" class="block mb-2 font-bold text-[#FFA168] dark:text-white">@lang('public.name')</label>
            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white @error('name') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.name')" value="{{ @$post->name }}">
            @error('name')
            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <h3 class="block mb-2 font-bold text-[#FFA168] dark:text-white">@lang('public.status')</h3>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="status" value="on" class="sr-only peer" @if(@$post->status == 1 || $title == 'Add') checked @endif>
                <span class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-[#FFA168]"></span>
            </label>
        </div>

        @if($title == 'Add')
            <button type="submit" class="w-full text-white bg-[#FFA168] hover:bg-orange-400 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">@lang('public.add_pamm')</button>
        @elseif($title = 'Edit')
            <button type="submit" class="w-full text-white bg-[#4DA5FF] hover:bg-blue-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">@lang('public.update_pamm')</button>
        @endif
    </form>


@endsection

