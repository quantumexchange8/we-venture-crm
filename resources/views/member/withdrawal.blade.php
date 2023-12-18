@extends('layouts.master-member')

@section('title')
    Withdrawals
@endsection

@section('contents')

    <nav class="flex mb-4 max-[900px]:flex-col" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xl font-semibold mb-4">
            <li class="inline-flex items-center">
                <p href="#"
                   class="inline-flex items-center text-gray-700 hover:text-orange-600 dark:text-gray-400 dark:hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                         stroke="currentColor" class="w-6 h-6 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3"/>
                    </svg>
                    @lang('public.wallet')
                </p>
            </li>
            <li>
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                              clip-rule="evenodd"></path>
                    </svg>
                    <p href="#"
                       class="ml-1  text-gray-700 hover:text-orange-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">
                        @lang('public.withdrawals')</p>
                </div>
            </li>
        </ol>

    </nav>
    <div class=" w-auto ">
        <div class="px-4">
            <form action="{{ url('member/withdrawals') }}" method="post" class="grid grid-cols-2 gap-3 mb-4 max-[1450px]:grid-cols-2 max-[1100px]:grid-cols-1">
                @csrf
                <div date-rangepicker datepicker-format="yyyy/mm/dd" class="flex items-center">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="text" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-blue-500" placeholder="@lang('public.select_start_date')" autocomplete="off" name="created_start" value="{{ @$search['created_start'] }}">
                    </div>
                    <span class="mx-4 text-gray-500">@lang('public.to')</span>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="text" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-blue-500" placeholder="@lang('public.select_end_date')" autocomplete="off" name="created_end" value="{{ @$search['created_end'] }}">
                    </div>
                </div>
                <div class="w-full mr-4 ">
                    <select id="status" name="filter_status"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500">
                        <option selected value="all">@lang('public.filter_status')</option>
                        @foreach(\App\Models\Withdrawals::listApprovalStatus() as $status)
                            <option {{ @$search['filter_status'] == $status ? 'selected' : '' }} value="{{ $status }}">{{ trans('public.'.\App\Models\Withdrawals::getApprovalStatus($status)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button data-tooltip-target="tooltip-search" type="submit" name="submit" value="search" class="mb-2 max-[1000px]:w-full justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg p-2.5 text-center inline-flex items-center mr-2 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                    <div id="tooltip-search" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        @lang('public.search')
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <button data-tooltip-target="tooltip-reset" type="submit" name="submit" value="reset" class="mb-2 max-[1000px]:w-full justify-center text-white bg-rose-500 hover:bg-rose-800 focus:ring-4 focus:outline-none focus:ring-rose-300 font-medium rounded-lg text-lg p-2.5 text-center inline-flex items-center mr-2 dark:bg-rose-600 dark:hover:bg-rose-700 dark:focus:ring-rose-800">
                        <svg class="h-4 w-4 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -5v5h5" />  <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 5v-5h-5" /></svg>
                    </button>
                    <div id="tooltip-reset" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        @lang('public.reset')
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <button type="submit" name="submit" value="export" class="mb-2 max-[1000px]:w-full justify-center text-white bg-secondary-800 hover:bg-secondary-500 focus:ring-4 text-sm focus:outline-none focus:ring-secondary-300 font-semibold rounded-lg px-5 py-2 text-center inline-flex items-center dark:bg-secondary-600 dark:hover:bg-secondary-700 dark:focus:ring-secondary-800">
                        <svg class="h-5 w-5 mr-2" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 15V6C8 4.89543 8.89543 4 10 4H38C39.1046 4 40 4.89543 40 6V42C40 43.1046 39.1046 44 38 44H10C8.89543 44 8 43.1046 8 42V33" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M31 15H34" stroke="#ffffff" stroke-width="3" stroke-linecap="round"/>
                            <path d="M28 23H34" stroke="#ffffff" stroke-width="3" stroke-linecap="round"/>
                            <path d="M28 31H34" stroke="#ffffff" stroke-width="3" stroke-linecap="round"/>
                            <rect x="4" y="15" width="18" height="18" fill="none" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10 21L16 27" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 21L10 27" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        @lang('public.export_excel')
                    </button>
                    @if(auth()->user()->withdrawal_action == \App\Models\User::ENABLE_WITHDRAWAL && auth()->user()->kyc_approval_status == \App\Models\User::KYC_STATUS_VERIFIED && $wallet_address && auth()->user()->withdrawal_pin )
                        <button type="button" data-modal-target="withdrawModal" data-modal-toggle="withdrawModal" class="mb-2 max-[1000px]:w-full justify-center text-white bg-success-500 hover:bg-success-600 focus:ring-4 text-sm focus:outline-none focus:ring-success-300 font-semibold rounded-lg px-5 py-2 text-center inline-flex items-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            @lang('public.withdraw')
                        </button>
                    @else
                        <h2 class="mb-2 font-semibold text-gray-900 dark:text-white">@lang('public.to_withdraw')</h2>
                        <ul class="max-w-md text-sm space-y-1 text-gray-500 list-inside dark:text-gray-400">
                            @if(auth()->user()->withdrawal_action == \App\Models\User::ENABLE_WITHDRAWAL && $wallet_address)
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-green-500 dark:text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    <span>@lang('public.setup_usdt_wallet')</span>
                                </li>
                            @else
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                    <span>@lang('public.setup_usdt_wallet') <a href="{{ route('member_profile') }}" class="text-primary"> (@lang('public.click_here_to_set_up_usdt_wallet'))</a></span>
                                </li>
                            @endif

                            @if(auth()->user()->withdrawal_action == \App\Models\User::ENABLE_WITHDRAWAL && auth()->user()->withdrawal_pin)
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-green-500 dark:text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    <span>@lang('public.setup_withdrawal_pin')</span>
                                </li>
                            @else
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                    <span>@lang('public.setup_withdrawal_pin') <a href="{{ route('member_profile') }}" class="text-primary"> (@lang('public.click_here_to_set_up_withdrawal_pin'))</a></span>
                                </li>
                            @endif

                            @if(auth()->user()->kyc_approval_status == \App\Models\User::KYC_STATUS_VERIFIED)
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-green-500 dark:text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    <span>@lang('public.profile_verified')</span>
                                </li>
                            @else
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                    <span>@lang('public.pending_kyc')</span>
                                </li>
                            @endif
                        </ul>
                    @endif
                </div>

            </form>

            <div class="relative overflow-x-auto sm:rounded-lg">
                <table class="w-full text-md text-left text-gray-500">
                    <thead class="text-md text-orange-500 uppercase border-b">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                @sortablelink('created_at', trans('public.date'))
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                @sortablelink('status', trans('public.status'))
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                @sortablelink('address', trans('public.address'))
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                @sortablelink('network', trans('public.method'))
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                @sortablelink('amount', trans('public.amount'))
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            @lang('public.action')
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($withdrawals as $data)
                        <tr class="odd:bg-white even:bg-[#FDFCF3] border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$data->created_at}}
                            </th>
                            @switch($data->status)
                                @case(\App\Models\Withdrawals::STATUS_PENDING)
                                    <td class="px-6 py-4 text-primary font-semibold">
                                    @lang('public.process')
                                    @break

                                @case(\App\Models\Withdrawals::STATUS_APPROVED)
                                    <td class="px-6 py-4 text-success font-semibold">
                                    @lang('public.approved')
                                    @break

                                @case(\App\Models\Withdrawals::STATUS_REJECTED)
                                    <td class="px-6 py-4 text-danger font-semibold">
                                    @lang('public.rejected')
                                    @break

                                @case(\App\Models\Withdrawals::STATUS_CANCELLED)
                                    <td class="px-6 py-4 text-warning font-semibold">
                                    @lang('public.cancelled')
                                    @break

                                @default
                                <td class="px-6 py-4 text-primary font-semibold">
                                    @lang('public.process')
                            @endswitch
                            </td>
                            <td class="px-6 py-4">
                                {{$data->address}}
                            </td>
                            <td class="px-6 py-4">
                                {{$data->getNetwork()}}
                            </td>
                            <td class="px-6 py-4">
                                $ {{ number_format($data->amount,2) }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    @if(auth()->user()->withdrawal_action == \App\Models\User::ENABLE_WITHDRAWAL && $data->status == \App\Models\Withdrawals::STATUS_PENDING)
                                        <a href="#withdrawal-edit-{{ $data->id }}"
                                           data-modal-target="withdrawal-edit-{{ $data->id }}" data-modal-toggle="withdrawal-edit-{{ $data->id }}"
                                           data-te-ripple-init
                                           data-te-ripple-color="light" data-tooltip-target="tooltip-edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 fill-primary hover:fill-primary-400">
                                                <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                            </svg>
                                        </a>
                                        <div id="tooltip-edit" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                            @lang('public.edit')
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        @include('member.withdrawal-modal')
                                        <a href="javascript:void(0)" data-tooltip-target="tooltip-cancel" class="cancel"
                                           data-modal-target="cancel_modal" data-modal-toggle="cancel_modal"
                                           data-te-ripple-init
                                           data-te-ripple-color="light" id="{{ $data->id }}">
                                            <svg class="h-7 w-7 text-red-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </a>
                                        <div id="tooltip-cancel" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                            @lang('public.cancel')
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    @else
                                        <span class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">@lang('public.done')</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <div class=" mt-4">
                <!-- Help text -->
                <span class="text-sm text-gray-700 dark:text-gray-400">
                    @if(count($withdrawals) > 0)
                        <div class="my-4">
                            {!! $withdrawals->links() !!}
                        </div>
                    @else
                        <div
                            class="w-full flex p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800"
                            role="alert">
                            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor"
                                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd"
                                                                                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                                                              clip-rule="evenodd"></path></svg>
                            <span class="sr-only">@lang('public.info')</span>
                            <div>
                                <span class="font-medium">@lang('public.info') :</span>@lang('public.no_record')
                            </div>

                    @endif
                </span>
            </div>
        </div>
    </div>
    <div id="withdrawModal" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto">
            <!-- Modal content -->

            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-md p-4 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-hide="withdrawModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">@lang('public.close_modal')</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-semibold text-orange-500 dark:text-white">@lang('public.withdrawal_as_USDT')</h3>
                    <form method="post" action="{{ url('member/store-withdrawal') }}"
                          enctype="multipart/form-data" id="withdrawal-modal">@csrf
                        <div class="mb-4">
                            <div class="mb-4">
                                <label for="balance"
                                       class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">@lang('public.available_balance')
                                </label>
                                <input type="text" name="balance" id="balance" aria-label="disabled input 1" disabled
                                       readonly value="{{number_format($user->wallet_balance, 2)}} USDT"
                                       class="bg-gray-50 border border-gray-300 text-orange-500 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                       required>
                            </div>
                            <div class="mb-4">
                                <label for="amount"
                                       class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">@lang('public.withdrawal_amount')
                                </label>
                                <div class="relative">
                                    <input type="number" name="amount" id="amount-wallet-add" value="{{ old('amount') }}"
                                           step="0.01" min="0"
                                           placeholder="@lang('public.min_amount') $ 10"
                                           class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500">
                                    <button type="button" id="max-button-add"
                                            class="text-white absolute right-2.5 bottom-2.5 bg-orange-500 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                                        @lang('public.max')
                                    </button>
                                </div>
                                <span class="text-danger text-xs error-text amount_error"></span>
                            </div>
                            <div class="mb-4">
                                <label for="fee-add" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">
                                    @lang('public.transaction_fee')
                                </label>
                                <input type="text" name="fee" id="fee-add" readonly aria-label="disabled input 2"
                                       value="{{number_format($transaction_fee,2)}} USDT"
                                       class="bg-gray-50 border border-gray-300 text-orange-500 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                       required>
                                <div class="text-sm text-center text-gray-500">@lang('public.fee_remark')</div>
                            </div>

                            <div class="mb-4">
                                <label for="withdrawal_pin" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">
                                    @lang('public.withdrawal_pin')
                                </label>
                                <input type="password" name="withdrawal_pin" id="withdrawal_pin" aria-label="disabled input 2" class="bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Enter Pin">
                                <span class="text-danger text-xs error-text withdrawal_pin_error"></span>
                            </div>

                            <div class="text-center font-medium text-md mt-2 text-orange-500  dark:text-orange-700">
                                @lang('public.withdrawal_total')
                            </div>
                            <button type="submit" id="total-add"
                                    class="w-full text-white bg-success hover:ring-success  focus:ring-4 focus:outline-none focus:ring-success font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                0.00 USDT
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Modal -->
    <div id="cancel_modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="cancel_modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">@lang('public.close_modal')</span>
                </button>
                <div class="p-6 text-center">
                    <form method="POST" action="{{ route('withdrawal_cancel') }}">
                        @csrf
                        <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="modal-body">
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">@lang('public.cancel_withdrawal_confirmation')</h3>
                            <input type="hidden" name="withdrawal_id" id="withdrawal_id">
                        </div>
                        <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            @lang('public.cancel')
                        </button>
                        <button data-modal-hide="cancel_modal" type="button" class="text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">@lang('public.discard')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('.cancel').on('click', function() {
                var id = $(this).attr('id');
                $(".modal-body #withdrawal_id").val( id );
            });

            function maxAmountAdd() {
                $("#amount-wallet-add").val({{$user->wallet_balance}});
                walletmaxAmountAdd();
            }

            function maxAmountEdit() {
                $("#amount-wallet-edit").val({{$user->wallet_balance}});
                walletmaxAmountEdit();
            }

            function walletmaxAmountAdd() {
                var amountAdd = $("#amount-wallet-add").val();
                var feeAdd = {{\App\Models\Settings::where('name', 'withdrawal_transaction_fee')->first()->value}};
                $("#fee-add").attr('value', feeAdd);

                if (amountAdd > feeAdd) {
                    $("#total-add").html(amountAdd - feeAdd + ' USDT');
                } else {
                    $("#total-add").html('0.00 USDT');
                }
            }

            function walletmaxAmountEdit() {
                var amountEdit = parseFloat($("#amount-wallet-edit").val());
                var feeEdit = parseFloat("{{\App\Models\Settings::where('name', 'withdrawal_transaction_fee')->first()->value}}");
                $("#fee-edit").attr('value', feeEdit);

                if (amountEdit > feeEdit) {
                    $("#total-edit").html((amountEdit - feeEdit).toFixed(2) + ' USDT');
                } else {
                    $("#total-edit").html('0.00 USDT');
                }
            }

            $("#max-button-add").click(function() {
                maxAmountAdd();
            });

            $("#amount-wallet-add").on("input", function() {
                walletmaxAmountAdd();
            });

            $("#max-button-edit").click(function() {
                maxAmountEdit();
            });

            $("#amount-wallet-edit").on("input", function() {
                walletmaxAmountEdit();
            });

            $('#withdrawal-modal').on('submit', function(e) {
                e.preventDefault();
                var form = $(this)
                $.ajax({
                    method:$(this).attr('method'),
                    url:$(this).attr('action'),
                    data:new FormData(this),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function (){
                        form.find('span.error-text').text('');
                    },
                    success: function(data) {
                        if(data.status == 0) {
                            $.each(data.error, function (prefix, val){
                                $('span.'+prefix+'_error').text(val[0]);
                                $('.'+prefix).addClass('border-danger');
                            });
                        } else if (data.status == 2) {
                            Swal.fire({
                                title: '{{ trans('public.invalid_action') }}',
                                text: data.msg,
                                icon: 'error',
                                confirmButtonText: 'OK',
                                timer: 3000,
                                timerProgressBar: false,
                            });
                        } else {
                            Swal.fire({
                                title: '{{ trans('public.done') }}',
                                text: data.msg,
                                icon: 'success',
                                confirmButtonText: 'OK',
                                timer: 3000,
                                timerProgressBar: false,
                            }).then(function() {
                                location.reload();
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while processing your request.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            timer: 3000,
                            timerProgressBar: false,
                        });
                    }
                });
            });

            $('#edit-withdrawal').on('submit', function(e) {
                e.preventDefault();
                var form = $(this)
                $.ajax({
                    method:$(this).attr('method'),
                    url:$(this).attr('action'),
                    data:new FormData(this),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function (){
                        form.find('span.error-text').text('');
                    },
                    success: function(data) {
                        if(data.status == 0) {
                            $.each(data.error, function (prefix, val){
                                $('span.'+prefix+'_error').text(val[0]);
                                $('.'+prefix).addClass('border-danger');
                            });
                        } else if (data.status == 2) {
                            Swal.fire({
                                title: '{{ trans('public.invalid_action') }}',
                                text: data.msg,
                                icon: 'error',
                                confirmButtonText: 'OK',
                                timer: 3000,
                                timerProgressBar: false,
                            });
                        } else {
                            Swal.fire({
                                title: '{{ trans('public.done') }}',
                                text: data.msg,
                                icon: 'success',
                                confirmButtonText: 'OK',
                                timer: 3000,
                                timerProgressBar: false,
                            }).then(function() {
                                location.reload();
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while processing your request.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            timer: 3000,
                            timerProgressBar: false,
                        });
                    }
                });
            });
        });

    </script>
@endsection
