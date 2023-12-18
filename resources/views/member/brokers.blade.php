@extends('layouts.master-member')

@section('title') Broker List @endsection

@section('contents')

        <nav class="flex " aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-lg font-semibold">
                <li class="inline-flex items-center">
                <p href="#" class="inline-flex items-center text-gray-700 hover:text-orange-600 dark:text-gray-400 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 mr-4">
                <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z" />
                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd" />
                </svg>
                    @lang('public.broker&fund')
                </p>
                </li>
                <li>
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <p href="#" class="ml-1  text-gray-700 hover:text-orange-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">@lang('public.broker_list')</p>
                </div>
                </li>
            </ol>
        </nav>
        <div class="grid grid-cols-3 gap-6 my-4 max-[1100px]:grid-rows-auto max-[1450px]:grid-cols-2 max-[1100px]:grid-cols-1">
            @foreach($brokers as $broker)
            <div class="max-w-sm bg-[#FDFCF3] border border-orange-200 rounded-lg shadow hover:shadow-2xl">
                <div class="flex flex-row items-center justify-center ml-6 mt-6 align-baseline shrink-0 grow-0">
                    <img class="w-24 h-24 mb-3 object-contain shrink-0 grow-0 rounded-full shadow-lg justify-center bg-gray-50" src="{{ asset('uploads/brokers/' .$broker->broker_image)}}" />
                    <h5 class="ml-4 text-2xl font-bold text-orange-500 dark:text-white">{{$broker->name}}</h5>
                </div>
                <div class="p-5">
                    <p class="mb-3 font-normal text-gray-400 dark:text-gray-400">{{$broker->description}}</p>
                        <h5 class="mb-2 text-lg font-bold tracking-tight text-orange-400 dark:text-white"> @lang('public.instructor_note'):</h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{$broker->note}}</p>
                        <button data-modal-target="brokerModal{{$broker->id}}" data-modal-toggle="brokerModal{{$broker->id}}" class="flex mx-auto items-center px-3 py-2 text-md font-medium text-center text-white bg-orange-400 rounded-lg hover:bg-orange-500 focus:ring-4 focus:outline-none focus:ring-orange-300 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1 -ml-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            @lang('public.more')
                    </button>
                </div>
            </div>


            <!-- Broker Modal -->
            <div id="brokerModal{{$broker->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
                <div class="relative w-full h-full max-w-2xl md:h-auto">
                    <div class="relative bg-[#FDFCF3] rounded-lg shadow dark:bg-gray-700 p-2">
                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="brokerModal{{$broker->id}}">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">@lang('public.close_modal')</span>
                        </button>
                        <div class="p-6 space-y-2">
                            <div class="flex items-center space-x-4">
                                <img class="w-20 h-20 grow-0 shrink-0 rounded-full bg-gray-50" src="{{ asset('uploads/brokers/' .$broker->broker_image)}}" alt="">
                                <div class="font-medium dark:text-white">
                                    <div class="text-xl text-orange-400 font-bold">{{$broker->name}}</div>
                                    <div class="text-md text-gray-500 dark:text-gray-400">{{$broker->description}}</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <p class="text-medium leading-relaxed text-gray-500 dark:text-gray-400 px-2">
                                    {{$broker->name}} @lang('public.click_redirect_message'): <br>
                                    <a target="_blank" href="{{$broker->url}}" class="text-primary break-all">{{$broker->url}}</a>
                                </p>
                                <img class ="h-48 w-48 ml-auto" src="{{ asset('uploads/brokers/' .$broker->qr_image)}}">
                            </div>
                            <h5 class="text-lg font-bold tracking-tight text-orange-400 dark:text-white"> @lang('public.instructor_note'):</h5>
                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                                {{$broker->note}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach
        </div>

@endsection
