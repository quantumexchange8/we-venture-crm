@extends('layouts.master-admin')

@section('title') Dashboard @endsection

@section('contents')

    <div class="flex max-[700px]:block">
        <h1 class="flex-1 font-semibold text-2xl text-gray-500">@lang('public.dashboard')</h1>
    </div>

    <div class="grid grid-cols-3 gap-8 mt-4 max-[1350px]:grid-rows-auto max-[1350px]:grid-cols-2 max-[950px]:grid-cols-1">
        <div class="rounded overflow-hidden shadow-lg text-white" style="background: #fd7f6f;">
            <div class="px-6 py-4">
                <div class="flex items-center p-3">
                    <svg class="h-12 w-12 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />  <polyline points="7 10 12 15 17 10" />  <line x1="12" y1="15" x2="12" y2="3" /></svg>
                    <div class="flex-col" style="margin-left: 20px">
                        <h3 class="font-bold text-lg ">${{ number_format($total_group_sales, 2) }}</h3>
                        <h6 class="font-semibold text-sm text-[#696057]">@lang('public.total_group_sales')</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="rounded overflow-hidden shadow-lg text-white" style="background: #7eb0d5;">
            <div class="px-6 py-4">
                <div class="flex items-center p-3">
                    <svg class="h-12 w-12 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />  <polyline points="17 8 12 3 7 8" />  <line x1="12" y1="3" x2="12" y2="15" /></svg>
                    <div class="flex-col" style="margin-left: 20px">
                        <h3 class="font-bold text-lg ">${{ number_format($total_withdrawals, 2) }}</h3>
                        <h6 class="font-semibold text-sm text-[#696057]">@lang('public.total_withdrawals')</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="rounded overflow-hidden shadow-lg text-white" style="background: #b2e061;">
            <div class="px-6 py-4">
                <div class="flex items-center p-3">
                    <svg class="h-12 w-12 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />  <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" /></svg>
                    <div class="flex-col" style="margin-left: 20px">
                        <h3 class="font-bold text-lg ">${{ number_format($total_commissions, 2) }}</h3>
                        <h6 class="font-semibold text-sm text-[#696057]">@lang('public.total_commissions')</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="rounded overflow-hidden shadow-lg text-white" style="background: #bd7ebe;">
            <div class="px-6 py-4">
                <div class="flex items-center p-3">
                    <svg class="h-12 w-12 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />  <circle cx="9" cy="7" r="4" />  <path d="M23 21v-2a4 4 0 0 0-3-3.87" />  <path d="M16 3.13a4 4 0 0 1 0 7.75" /></svg>
                    <div class="flex-col" style="margin-left: 20px">
                        <h3 class="font-bold text-lg ">{{ number_format($total_members) }}</h3>
                        <h6 class="font-semibold text-sm text-[#696057]">@lang('public.total_members')</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="rounded overflow-hidden shadow-lg text-white" style="background: #ffb55a;">
            <div class="px-6 py-4">
                <div class="flex items-center p-3">
                    <svg class="h-12 w-12 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M9 5H7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2V7a2 2 0 0 0 -2 -2h-2" />  <rect x="9" y="3" width="6" height="4" rx="2" />  <line x1="9" y1="12" x2="9.01" y2="12" />  <line x1="13" y1="12" x2="15" y2="12" />  <line x1="9" y1="16" x2="9.01" y2="16" />  <line x1="13" y1="16" x2="15" y2="16" /></svg>
                    <div class="flex-col" style="margin-left: 20px">
                        <h3 class="font-bold text-lg ">$ {{ number_format($monthly_lot, 2) }}</h3>
                        <h6 class="font-semibold text-sm text-[#696057]">@lang('public.monthly_lot')</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="rounded overflow-hidden shadow-lg text-white" style="background: #beb9db;">
            <div class="px-6 py-4">
                <div class="flex items-center p-3">
                    <svg class="h-12 w-12 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M9 5H7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2V7a2 2 0 0 0 -2 -2h-2" />  <rect x="9" y="3" width="6" height="4" rx="2" />  <line x1="9" y1="12" x2="9.01" y2="12" />  <line x1="13" y1="12" x2="15" y2="12" />  <line x1="9" y1="16" x2="9.01" y2="16" />  <line x1="13" y1="16" x2="15" y2="16" /></svg>
                    <div class="flex-col" style="margin-left: 20px">
                        <h3 class="font-bold text-lg ">{{ number_format($lot_size_pool, 2) }}</h3>
                        <h6 class="font-semibold text-sm text-[#696057]">@lang('public.lot_size_pool')</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="accordion-open" data-accordion="open" class="mt-8 font-bold text-lg" data-active-classes="text-orange-400">
        @foreach($brokers as $broker)
            <h2 id="accordion-collapse-heading-{{$broker->id}}">
                <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-orange-200 focus:ring-4 focus:ring-orange-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 bg-[#FDFCF3] hover:bg-orange-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-{{$broker->id}}" aria-expanded="true" aria-controls="accordion-collapse-body-{{$broker->id}}">
                    <span class="font-bold text-lg">{{ $broker->name }}</span>
                    <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </h2>
            <div id="accordion-collapse-body-{{$broker->id}}" class="hidden" aria-labelledby="accordion-collapse-heading-{{$broker->id}}">
                <div class="p-5 border border-t-0 border-orange-200 dark:border-gray-700">
                    <span class="font-bold text-lg  text-sm text-orange-400 underline border-l-4 border-orange-400 pl-4 -ml-5">{{ $broker->name }}</span>
                    <div class="grid grid-cols-3 gap-8 mt-4 max-[1350px]:grid-rows-auto max-[1350px]:grid-cols-2 max-[950px]:grid-cols-1">
                        <div class="rounded overflow-hidden shadow-lg text-white" style="background: #fd7f6f;">
                            <div class="px-6 py-4">
                                <div class="flex items-center p-3">
                                    <svg class="h-12 w-12 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />  <polyline points="7 10 12 15 17 10" />  <line x1="12" y1="15" x2="12" y2="3" /></svg>
                                    <div class="flex-col" style="margin-left: 20px">
                                        <h3 class="font-bold text-lg ">${{number_format($broker->data['total_deposit'],2)}}</h3>
                                        <h6 class="font-semibold text-sm text-[#696057]">@lang('public.total_group_sales')</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="rounded overflow-hidden shadow-lg text-white" style="background: #b2e061;">
                            <div class="px-6 py-4">
                                <div class="flex items-center p-3">
                                    <svg class="h-12 w-12 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />  <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" /></svg>
                                    <div class="flex-col" style="margin-left: 20px">
                                        <h3 class="font-bold text-lg ">${{number_format($broker->data['total_commissions'],2)}}</h3>
                                        <h6 class="font-semibold text-sm text-[#696057]">@lang('public.total_commissions')</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="rounded overflow-hidden shadow-lg text-white" style="background: #bd7ebe;">
                            <div class="px-6 py-4">
                                <div class="flex items-center p-3">
                                    <svg class="h-12 w-12 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />  <circle cx="9" cy="7" r="4" />  <path d="M23 21v-2a4 4 0 0 0-3-3.87" />  <path d="M16 3.13a4 4 0 0 1 0 7.75" /></svg>
                                    <div class="flex-col" style="margin-left: 20px">
                                        <h3 class="font-bold text-lg ">{{$broker->data['clients']}}</h3>
                                        <h6 class="font-semibold text-sm text-[#696057]">@lang('public.total_members')</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
