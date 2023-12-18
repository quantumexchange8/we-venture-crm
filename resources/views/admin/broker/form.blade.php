@extends('layouts.master-admin')

@section('title') Brokers {{ $title }} @endsection

@section('contents')

    <div class="flex flex-row">
        <h1 class="flex-1 font-semibold text-2xl text-gray-500">@lang('public.brokers') / {{ ($title)== 'Add' ? trans('public.add_broker') : trans('public.update_broker') }} </h1>
        <a href="{{ route('broker_listing') }}" class="text-xl font-semibold text-[#FFA168]">@lang('public.back')</a>
    </div>
    <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
        <form class="space-y-6" action="{{ $submit }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-2 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                <div class="text-gray-600 mr-2">
                    <div class="mb-4">
                        <label for="url" class="block mb-2 font-bold text-[#FFA168] dark:text-white">@lang('public.url')</label>
                        <input type="text" id="url" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('url') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.url')" name="url" value="{{ @$post->url }}" >
                        @error('url')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="broker_image" class="block mb-2 font-bold text-[#FFA168] dark:text-white">@lang('public.broker_image')</label>
                        @if($title == 'Edit')
                            <img class="object-cover w-full rounded h-96 md:h-auto md:w-48 md:rounded-none md:rounded-lg mb-4" src="{{ asset('uploads/brokers/' .$broker->broker_image)}}" alt="">
                        @endif
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 @error('broker_image') block w-full text-sm text-red-900 border border-red-500 rounded-lg cursor-pointer bg-red-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 @enderror" aria-describedby="broker_image_desc" id="file_input" accept="image/png, image/gif, image/jpeg" type="file" name="broker_image" value="{{ @$post->broker_image }}">
                        @error('broker_image')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-300" id="broker_image_desc">@lang('public.broker_image_req')</p>
                    </div>
                    <div class="mb-4">
                        <label for="qr_image" class="block mb-2 font-bold text-[#FFA168] dark:text-white">@lang('public.qr_code')</label>
                        @if($title == 'Edit')
                            <img class="object-cover w-full rounded-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-lg mb-4" src="{{ asset('uploads/brokers/' .$broker->qr_image)}}" alt="">
                        @endif
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 @error('qr_image') block w-full text-sm text-red-900 border border-red-500 rounded-lg cursor-pointer bg-red-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 @enderror" aria-describedby="qr_image_desc" id="file_input" accept="image/png, image/gif, image/jpeg" type="file" name="qr_image" value="{{ @$post->qr_image }}">
                        @error('qr_image')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-300" id="qr_image_desc">@lang('public.broker_image_req')</p>
                    </div>
                </div>
                <div class="lg:col-span-2">
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
                            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="{{ $locale }}" role="tabpanel" aria-labelledby="{{ $locale }}-tab">
                                <div class="mb-6">
                                    <label for="name[{{ $locale }}]" class="block mb-2 font-bold text-[#FFA168] dark:text-white">@lang('public.name') ( @lang('public.'.$locale ) )</label>
                                    <input type="text" id="name[{{ $locale }}]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error($locale.'.name') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.name') ( @lang('public.'.$locale ) )" name="{{ $locale }}[name]"
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
                                <div class="grid gap-6 mb-6 md:grid-cols-2">
                                    <div>
                                        <label for="description[{{ $locale }}]" class="block mb-2 font-bold text-[#FFA168] dark:text-white">@lang('public.description') ( @lang('public.'.$locale ) )</label>
                                        <textarea id="description[{{ $locale }}]" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error($locale.'.description') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.description') ( @lang('public.'.$locale ) )" name="{{ $locale }}[description]" >@if($title == 'Add'){{ @$post->$locale['description'] }}@else{{ @$post->translate($locale)->description }}@endif</textarea>
                                        @error($locale.'.description')
                                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="note[{{ $locale }}]" class="block mb-2 font-bold text-[#FFA168] dark:text-white">@lang('public.instructor_note') ( @lang('public.'.$locale ) )</label>
                                        <textarea id="note[{{ $locale }}]" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error($locale.'.note') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.instructor_note') ( @lang('public.'.$locale ) )" name="{{ $locale }}[note]" >@if($title == 'Add'){{ @$post->$locale['note'] }}@else{{ @$post->translate($locale)->note }}@endif</textarea>
                                        @error($locale.'.note')
                                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($title == 'Add')
                        <button type="submit" class="float-right text-white bg-[#40DD7F] hover:bg-[#40DD7F]/90 focus:ring-4 focus:outline-none focus:ring-[#40DD7F]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#40DD7F]/55 mb-2">
                            <svg class="h-6 w-6 text-white"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="ml-2">@lang('public.create_broker')</span>
                        </button>
                    @elseif($title == 'Edit')
                        <button type="submit" class="float-right text-white bg-[#1A8BFF] hover:bg-[#1A8BFF]/90 focus:ring-4 focus:outline-none focus:ring-[#1A8BFF]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#1A8BFF]/55 mr-2 mb-2">
                            <svg class="h-6 w-6 text-white"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="ml-2">@lang('public.update_broker')</span>
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>



@endsection
