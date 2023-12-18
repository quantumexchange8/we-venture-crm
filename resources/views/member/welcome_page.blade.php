@extends('layouts.master-member')

@section('title') Welcome @endsection

@section('contents')

        <div class="grid grid-cols-2 max-[1000px]:grid-cols-1 gap-6 mb-6">
            <div class="w-full bg-[#FDFCF3] border border-gray-200 rounded-lg shadow hover:shadow-xl dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-end px-4 pt-4">
                    <button id="dropdownButton" data-dropdown-toggle="dropdown" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-orange-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-orange-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
                        <span class="sr-only">Open dropdown</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdown" class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2" aria-labelledby="dropdownButton">
                            <li>
                                <a href="{{ route('member_profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">@lang('public.profile')</a>
                            </li>
                            <li>
                                <a href="{{ route('member_change_password') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">@lang('public.change_password')</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="flex-shrink-0 grow-0 mb-2">
                        @if ($user->profile_image)
                            <img src="{{ asset('uploads/users/' .$user->profile_image)}}" class="w-24 h-24 rounded-full shadow-lg bg-gray-100" alt="">
                        @else
                            <img src="{{url('/img/profile.png')}}" class="w-24 h-24 rounded-full shadow-lg bg-orange-400" alt="">
                        @endif
                    </div>
                    <h5 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h5>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ trans('public.'.$user->rank->rank_short_form) }}</span>
                </div>

                <div class="p-6">
                    <h5 class="mb-4 text-xl font-bold text-orange-400 dark:text-gray-400">
                        @if($user->kyc_approval_status == 1 || $user->kyc_approval_status == 4)
                            @lang('public.pending_upload')
                        @elseif($user->kyc_approval_status == 2)
                            @lang('public.pending')
                        @elseif($user->kyc_approval_status == 3)
                            @lang('public.kyc_approved')
                        @endif
                    </h5>
                    <p class="text-sm text-gray-500">@lang('public.pending_description')</p>

                    <!-- List -->
                    <ul role="list" class="space-y-5 my-7">
                        <li class="flex space-x-3">
                            <!-- profile verification -->
                            @if($user->kyc_approval_status == 1 || $user->kyc_approval_status == 4)
                                <svg class="h-5 w-5 text-red-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="18" y1="6" x2="6" y2="18" />  <line x1="6" y1="6" x2="18" y2="18" /></svg>
                                <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">@lang('public.profile_verification')</span>
                            @elseif($user->kyc_approval_status == 2)
                                <svg class="h-5 w-5 text-red-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="18" y1="6" x2="6" y2="18" />  <line x1="6" y1="6" x2="18" y2="18" /></svg>
                                <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">@lang('public.profile_verification')</span>
                            @elseif($user->kyc_approval_status == 3)
                                <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-success-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Check icon</title><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                <span class="text-base font-normal leading-tight text-gray-500">@lang('public.profile_verification')</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
            <div class="w-full p-6 bg-[#FDFCF3] border border-gray-200 rounded-lg shadow hover:shadow-xl sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <h2 class="mb-6 text-2xl font-bold tracking-tight text-orange-400 dark:text-white">@lang('public.investment')</h2>
                @if(count($portfolios) > 0)
                    @foreach($portfolios as $portfolio)
                        <div class="mb-6 font-normal text-gray-700 dark:text-gray-400">
                            <ul class="space-y-4 text-gray-500 list-disc list-inside dark:text-gray-400">
                                <li>
                                    {{ $portfolio->name }}
                                    <p class="ml-6">
                                        {!! $portfolio->description !!}
                                    </p>
                                </li>
                            </ul>
                        </div>
                    @endforeach
                @else
                    <div class="mb-6 font-normal text-gray-700 dark:text-gray-400">
                        <span class="bg-yellow-100 text-yellow-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Coming Soon</span>
                    </div>
                @endif

                <a href="{{ route('investment.portfolio') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-orange-400 rounded-lg hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                    @lang('public.read_more')
                    <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </a>
            </div>
        </div>

        <!-- news -->
        <div class="max-w p-6 bg-[#FDFCF3] border border-gray-200 rounded-lg shadow hover:shadow-xl dark:bg-gray-800 dark:border-gray-700">
            @if(!empty($news))
                <h2 class="mb-6 underline text-2xl font-bold tracking-tight text-orange-400 dark:text-white">{{ $news->title }}</h2>
                <div class="mb-6 font-normal text-gray-700 dark:text-gray-400">
                    <p class="text-2xl text-gray-400 dark:text-gray-500">{!! $news->content !!}</p>
                    <div class="mt-6 flex justify-center">
                        <figure class="max-w-lg">
                            <img class="h-auto max-w-full rounded-lg" src="{{ $news->getFirstMediaUrl('news_image') }}" alt="image description">
                        </figure>
                    </div>
                </div>
                <a href="{{ route('member_dashboard') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-orange-400 rounded-lg hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                    @lang('public.read_more')
                    <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </a>
            @else
                <p class="text-xl text-orange-400">@lang('public.welcome_back'), {{ auth()->user()->name }}!</p>
            @endif

        </div>

        <button class="hidden" data-te-toggle="modal" data-te-target="#eventModalPopUp" id="popUpTrigger">Pop Up</button>
        <div
            data-te-modal-init
            class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="eventModalPopUp"
            tabindex="-1"
            aria-labelledby="eventModalPopUp_label"
            aria-hidden="true">
            <div
                data-te-modal-dialog-ref
                class="pointer-events-none relative h-[calc(100%-1rem)] w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
                <div
                    class="pointer-events-auto relative flex max-h-[100%] w-full flex-col overflow-hidden rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                        <div
                            class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                            <h5
                                class="text-xl font-medium leading-normal text-orange-400 dark:text-neutral-200"
                                id="eventModalPopUp_label">
                                @lang('public.event')
                            </h5>
                            <button
                                type="button"
                                class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                                data-te-modal-dismiss
                                aria-label="Close">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-6 w-6 text-gray-300">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="relative overflow-y-auto p-4">
                            <div id="default-carousel" class="relative w-full h-full" data-carousel="slide">
                                <!-- Carousel wrapper -->
                                <div class="relative h-screen overflow-y-auto overflow-x-hidden rounded-lg">
                                    @foreach($events as $event)
                                        @if($events->count() == 1)
                                            <h5
                                                class="text-xl font-medium leading-normal text-orange-400 dark:text-neutral-200">
                                                {{ $event->event_title }}
                                            </h5>
                                            @if($event->hasMedia('event_images'))
                                                @foreach($event->getMedia('event_images') as $event_img)
                                                    <img src="{{ $event_img->getUrl() }}" class="object-cover mx-auto my-6" alt="">
                                                @endforeach
                                            @endif
                                        @else
                                            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                                <h5
                                                    class="text-xl font-medium leading-normal text-orange-400 dark:text-neutral-200">
                                                    {{ $event->event_title }}
                                                </h5>
                                                @if($event->hasMedia('event_images'))
                                                    @foreach($event->getMedia('event_images') as $event_img)
                                                        <img src="{{ $event_img->getUrl() }}" class="object-cover mx-auto my-6" alt="">
                                                    @endforeach
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <!-- Slider controls -->
                                <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg aria-hidden="true" class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            <span class="sr-only">Previous</span>
        </span>
                                </button>
                                <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg aria-hidden="true" class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="sr-only">Next</span>
        </span>
                                </button>
                            </div>
                        </div>
                    <div
                        class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                        <button
                            type="button"
                            class="inline-block rounded bg-orange-100 px-6 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-orange-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200"
                            data-te-modal-dismiss
                            data-te-ripple-init
                            data-te-ripple-color="light">
                            @lang('public.close')
                        </button>
                    </div>
                </div>
            </div>
        </div>

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            var events = @json($events);
            if (events.length > 0) {
                $('#popUpTrigger').trigger('click');
            }
        });

    </script>
@endsection
