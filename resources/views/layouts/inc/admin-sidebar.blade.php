
<button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" data-drawer-backdrop="false" aria-controls="sidebar-multi-level-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-blue-100/20 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">@lang('public.open_sidebar')</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
    </svg>
</button>

<aside id="sidebar-multi-level-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <button type="button" data-drawer-hide="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" class="text-gray-400 min-[644px]:hidden bg-transparent hover:bg-blue-200 hover:text-blue-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" >
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        <span class="sr-only">@lang('public.close')</span>
    </button>
    <div class="h-full px-3 py-4 overflow-y-auto bg-[#00052D] dark:bg-gray-800">
        <img class="w-full h-40 mx-auto my-6" src="{{url('/img/WV.png')}}">
        <ul class="space-y-2">
            <li>
                <a href="{{ url('admin/dashboard') }}" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-blue-100/20 dark:hover:bg-gray-700">
                    <svg aria-hidden="true" class="w-6 h-6 {{ request()->is('admin/dashboard') ? 'text-blue-400' : 'text-white'}} transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
                    <span class="ml-3 {{ request()->is('admin/dashboard') ? 'font-semibold text-lg text-blue-400' : 'font-semibold text-lg text-white'}}">@lang('public.dashboard')</span>
                </a>
            </li>
            <li>
                @php
                    $kyc_approval_count = \App\Models\User::where('kyc_approval_status', 2)->count();

                    $walletRequest = \App\Models\UserWallet::where('wallet_address_request_status', \App\Models\UserWallet::STATUS_PENDING)->count();
                    $userProfileRequest = \App\Models\UserProfile::where('status', '=', 'pending')->count();
                @endphp
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-members" data-collapse-toggle="dropdown-members">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 {{ request()->is('admin/member/*') ? 'text-blue-400' : 'text-white'}}">
                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap {{ request()->is('admin/member/*') ? 'font-semibold text-lg text-blue-400' : 'font-semibold text-lg text-white'}}" sidebar-toggle-item>@lang('public.members')</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="dropdown-members" class="{{ request()->is('admin/member/*') ? '' : 'hidden' }} py-2 space-y-2">
                    <li>
                        <a href="{{ route('member_add') }}" class="{{ request()->is('admin/member/add') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-blue-400">@lang('public.add_members')</a>
                    </li>
                    <li>
                        <a href="{{ route('member_listing') }}" class="{{ request()->is('admin/member/listing') || request()->is('admin/member/details/*') || request()->is('admin/member/edit/*') || request()->is('admin/member/deposit/*') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 text-base font-semibold transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-blue-400">@lang('public.members_list')</a>
                    </li>
                    <li>
                        <a href="{{ route('acknowledgement_letter') }}" class="{{ request()->is('admin/member/acknowledgement_letter') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 text-base font-semibold transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-blue-400">@lang('public.acknowledgement_letter')</a>
                    </li>
                    <li>
                        <a href="{{ route('member_wallet') }}" class="{{ request()->is('admin/member/member_wallet') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 text-base font-semibold transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-blue-400">@lang('public.member_wallet')
                            @if($walletRequest > 0)
                                <span class="inline-flex items-center justify-center w-3 h-3 p-3 ml-3 text-sm font-medium text-white bg-blue-500 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ $walletRequest }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('member_profile_request') }}" class="{{ request()->is('admin/member/member_profile_request') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 text-base font-semibold transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-blue-400">@lang('public.member_profile')
                            @if($userProfileRequest > 0)
                                <span class="inline-flex items-center justify-center w-3 h-3 p-3 ml-3 text-sm font-medium text-white bg-blue-500 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ $userProfileRequest }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('extra_bonus_listing') }}" class="{{ request()->is('admin/member/extra_bonus/listing') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-blue-400">@lang('public.extra_bonus')</a>
                    </li>
                </ul>
            </li>
            <li>
                @php
                    $withdrawal_count = \App\Models\Withdrawals::where('status', 1)->count();
                    $worldPoolRequest = \App\Models\WorldPoolHistory::where('status', 1)->count();
                @endphp
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-report" data-collapse-toggle="dropdown-report">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 {{ request()->is('admin/report/*') ? 'text-blue-400' : 'text-white'}}">
                        <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 013.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 013.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 01-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875zM9.75 17.25a.75.75 0 00-1.5 0V18a.75.75 0 001.5 0v-.75zm2.25-3a.75.75 0 01.75.75v3a.75.75 0 01-1.5 0v-3a.75.75 0 01.75-.75zm3.75-1.5a.75.75 0 00-1.5 0V18a.75.75 0 001.5 0v-5.25z" clip-rule="evenodd" />
                        <path d="M14.25 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0016.5 7.5h-1.875a.375.375 0 01-.375-.375V5.25z" />
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap {{ request()->is('admin/report/*') ? 'font-semibold text-lg text-blue-400' : 'font-semibold text-lg text-white'}}" sidebar-toggle-item>@lang('public.reports')</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="dropdown-report" class="{{ request()->is('admin/report/*') ? '' : 'hidden' }} py-2 space-y-2">
                    <li>
                        <button type="button" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-8 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-white" aria-controls="dropdown-commission" data-collapse-toggle="dropdown-commission-child">
                            <span class="flex-1 ml-3 text-left whitespace-nowrap text-sm {{ request()->is('admin/report/commissions/*') ? 'font-semibold text-lg text-blue-400' : 'font-semibold text-lg text-white'}}" sidebar-toggle-item>@lang('public.commissions')</span>
                            <svg sidebar-toggle-item class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                        <ul id="dropdown-commission-child" class="{{ request()->is('admin/report/commissions/*') ? '' : 'hidden' }} py-2 space-y-2 ml-4">
                            <li>
                                <a href="{{ route('report_commission') }}" class="{{ request()->is('admin/report/commissions/listing') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} font-normal flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 text-blue-400">@lang('public.listing')</a>
                            </li>
                            <li>
                                <a href="{{ route('report_commission_children') }}" class="{{ request()->is('admin/report/commissions/children') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} font-normal flex items-center w-full p-2 text-base font-semibold transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 text-blue-400">@lang('public.downline_listing')</a>
                            </li>
                            <li>
                                <button type="button" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-8 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-white" aria-controls="monthly_lot_size" data-collapse-toggle="monthly_lot_size">
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap text-sm {{ request()->is('admin/report/commissions/monthly_lot_size/*') ? 'font-semibold text-lg text-blue-400' : 'font-semibold text-lg text-white'}}" sidebar-toggle-item>@lang('public.monthly_lot')</span>
                                    <svg sidebar-toggle-item class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                </button>
                                <ul id="monthly_lot_size" class="{{ request()->is('admin/report/commissions/monthly_lot_size/*') ? '' : 'hidden' }} py-2 space-y-2 ml-4">
                                    <li>
                                        <a href="{{ route('report_commission_lot') }}" class="{{ request()->is('admin/report/commissions/monthly_lot_size/listing') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-blue-400">@lang('public.listing')</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('lot_size_downline_listing') }}" class="{{ request()->is('admin/report/commissions/monthly_lot_size/downline_listing') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 text-base font-semibold transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-blue-400">@lang('public.downline_listing')</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <button type="button" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-8 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-white" aria-controls="dropdown-deposits" data-collapse-toggle="dropdown-deposits-child">
                            <span class="flex-1 ml-3 text-left whitespace-nowrap text-sm {{ request()->is('admin/report/deposits/*') ? 'font-semibold text-lg text-blue-400' : 'font-semibold text-lg text-white'}}" sidebar-toggle-item>@lang('public.deposits')</span>
                            <svg sidebar-toggle-item class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                        <ul id="dropdown-deposits-child" class="{{ request()->is('admin/report/deposits/*') ? '' : 'hidden' }} py-2 space-y-2 ml-4">
                            <li>
                                <a href="{{ route('report_deposits') }}" class="{{ request()->is('admin/report/deposits/listing') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-normal text-blue-400">@lang('public.listing')</a>
                            </li>
                            <li>
                                <a href="{{ route('report_deposits_children') }}" class="{{ request()->is('admin/report/deposits/children') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 text-base font-semibold transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-normal text-blue-400">@lang('public.downline_listing')</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <button type="button" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-8 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-white" aria-controls="dropdown-withdrawals" data-collapse-toggle="dropdown-withdrawals-child">
                            <span class="flex-1 ml-3 text-left whitespace-nowrap text-sm {{ request()->is('admin/report/withdrawals/*') ? 'font-semibold text-lg text-blue-400' : 'font-semibold text-lg text-white'}}" sidebar-toggle-item>@lang('public.withdrawals')
                                @if($withdrawal_count > 0)
                                    <span class="inline-flex items-center justify-center w-3 h-3 p-3 ml-3 text-sm font-medium text-white bg-blue-500 rounded-full dark:bg-blue-900 dark:text-blue-300">!</span>
                                @endif
                            </span>
                            <svg sidebar-toggle-item class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                        <ul id="dropdown-withdrawals-child" class="{{ request()->is('admin/report/withdrawals/*') ? '' : 'hidden' }} py-2 space-y-2 ml-4">
                            <li>
                                <a href="{{ route('report_withdrawal') }}" class="{{ request()->is('admin/report/withdrawals/listing') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-normal text-blue-400">
                                    @lang('public.listing')
                                    @if($withdrawal_count > 0)
                                        <span class="inline-flex items-center justify-center w-3 h-3 p-3 ml-3 text-sm font-medium text-white bg-blue-500 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ $withdrawal_count }}</span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('report_withdrawal_children') }}" class="{{ request()->is('admin/report/withdrawals/children') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 text-base font-semibold transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-normal text-blue-400">
                                    @lang('public.downline_listing')
                                    @if($withdrawal_count > 0)
                                        <span class="inline-flex items-center justify-center w-3 h-3 p-3 ml-3 text-sm font-medium text-white bg-blue-500 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ $withdrawal_count }}</span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <button type="button" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-8 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-white" aria-controls="dropdown-networks" data-collapse-toggle="dropdown-networks-child">
                            <span class="flex-1 ml-3 text-left whitespace-nowrap text-sm {{ request()->is('admin/report/network/*') ? 'font-semibold text-lg text-blue-400' : 'font-semibold text-lg text-white'}}" sidebar-toggle-item>@lang('public.network')
                            </span>
                            <svg sidebar-toggle-item class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                        <ul id="dropdown-networks-child" class="{{ request()->is('admin/report/network/*') ? '' : 'hidden' }} py-2 space-y-2 ml-4">
                            <li>
                                <a href="{{ route('bonus_history_listing') }}" class="{{ request()->is('admin/report/network/listing') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-normal text-blue-400">
                                    @lang('public.listing')
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('bonus_history_summary') }}" class="{{ request()->is('admin/report/network/summary') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 text-base font-semibold transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-normal text-blue-400">
                                    @lang('public.summary')
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('performance_bonus_listing') }}" class="{{ request()->is('admin/report/performance_bonus/listing') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-blue-400">@lang('public.performance_bonus')</a>
                    </li>
                    <li>
                        <a href="{{ route('wallet_logs_listing') }}" class="{{ request()->is('admin/report/wallets/listing') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-blue-400">@lang('public.wallets_log')</a>
                    </li>
                    <li>
                        <a href="{{ route('ranking_logs_listing') }}" class="{{ request()->is('admin/report/ranking/listing') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-blue-400">@lang('public.ranking_log')</a>
                    </li>
                    <li>
                        <a href="{{ route('deleted_member') }}" class="{{ request()->is('admin/report/deleted_member') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-blue-400">@lang('public.deleted_member')</a>
                    </li>
                    <li>
                        <a href="{{ route('world_pool') }}" class="{{ request()->is('admin/report/world_pool') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-blue-400">
                            @lang('public.world_pool')
                            @if($worldPoolRequest > 0)
                                <span class="inline-flex items-center justify-center w-3 h-3 p-3 ml-3 text-sm font-medium text-white bg-blue-500 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ $worldPoolRequest }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-referrals" data-collapse-toggle="dropdown-referrals">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 {{ request()->is('admin/referral/*') ? 'text-blue-400' : 'text-white'}}">
                        <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z" clip-rule="evenodd" />
                        <path d="M5.082 14.254a8.287 8.287 0 00-1.308 5.135 9.687 9.687 0 01-1.764-.44l-.115-.04a.563.563 0 01-.373-.487l-.01-.121a3.75 3.75 0 013.57-4.047zM20.226 19.389a8.287 8.287 0 00-1.308-5.135 3.75 3.75 0 013.57 4.047l-.01.121a.563.563 0 01-.373.486l-.115.04c-.567.2-1.156.349-1.764.441z" />
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap {{ request()->is('admin/referral/*') ? 'font-semibold text-lg text-blue-400' : 'font-semibold text-lg text-white'}}" sidebar-toggle-item>@lang('public.referrals')</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="dropdown-referrals" class="{{ request()->is('admin/referral/*') ? '' : 'hidden' }} py-2 space-y-2">
                    <li>
                        <a href="{{ route('referral_tree') }}" class="{{ request()->is('admin/referral/referral_tree') || request()->is('admin/referral/referral_tree/*') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-blue-400">@lang('public.referrals_tree')</a>
                    </li>
                    <li>
                        <a href="{{ route('referral_transfer') }}" class="{{ request()->is('admin/referral/transfer') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 text-base font-semibold transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-blue-400">@lang('public.transfer')</a>
                    </li>
                </ul>
            </li>
            <li>
                @php
                    $investment_count = \App\Models\Investment::where('status', '=', 'processing')->count();
                @endphp
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown_investment" data-collapse-toggle="dropdown_investment">
                    <svg class="h-8 w-8 {{ request()->is('admin/investment/*') ? 'text-blue-400' : 'text-white'}}"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="4" y1="19" x2="20" y2="19" />  <polyline points="4 15 8 9 12 11 16 6 20 10" /></svg>
                    <span class="flex-1 ml-1 text-left whitespace-nowrap {{ request()->is('admin/investment/*') ? 'font-semibold text-lg text-blue-400' : 'font-semibold text-lg text-white'}}" sidebar-toggle-item>@lang('public.investment')
                        @if($investment_count > 0)
                            <span class="inline-flex items-center justify-center w-3 h-3 p-3 ml-3 text-sm font-medium text-white bg-blue-500 rounded-full dark:bg-blue-900 dark:text-blue-300">!</span>
                        @endif
                    </span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="dropdown_investment" class="{{ request()->is('admin/investment/*') ? '' : 'hidden' }} py-2 space-y-2">
                    <li>
                    <button type="button" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-8 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-white" aria-controls="dropdown_investment" data-collapse-toggle="dropdown-investment-child">
                            <span class="flex-1 ml-3 text-left whitespace-nowrap text-sm {{ request()->is('admin/investment/add_portfolio') || request()->is('admin/investment/portfolio_edit/*') || request()->is('admin/investment/portfolio_listing') ? 'font-semibold text-lg text-blue-400' : 'font-semibold text-lg text-white'}}" sidebar-toggle-item>@lang('public.portfolio')
                            </span>
                        <svg sidebar-toggle-item class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    <ul id="dropdown-investment-child" class="{{ request()->is('admin/investment/add_portfolio') || request()->is('admin/investment/portfolio_edit/*') || request()->is('admin/investment/portfolio_listing') ? '' : 'hidden' }} py-2 space-y-2 ml-4">
                        <li>
                            <a href="{{ route('add_portfolio') }}" class="{{ request()->is('admin/investment/add_portfolio') || request()->is('admin/investment/portfolio_edit/*') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-normal text-blue-400">
                                @lang('public.add_portfolio')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('portfolio_listing') }}" class="{{ request()->is('admin/investment/portfolio_listing') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 text-base font-semibold transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-normal text-blue-400">
                                @lang('public.portfolio_listing')
                            </a>
                        </li>
                    </ul>
                </li>
                    <li>
                        <a href="{{ route('investment_listing') }}" class="{{ request()->is('admin/investment/investment_listing') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 text-base font-semibold transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-blue-400">@lang('public.listing')
                            @if($investment_count > 0)
                                <span class="inline-flex items-center justify-center w-3 h-3 p-3 ml-3 text-sm font-medium text-white bg-blue-500 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ $investment_count }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('broker_listing') }}" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-blue-100/20 dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 {{ request()->is('admin/broker/*') ? 'text-blue-400' : 'text-white'}}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap {{ request()->is('admin/broker/*') ? 'font-semibold text-lg text-blue-400' : 'font-semibold text-lg text-white'}}">@lang('public.brokers')</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pamm_listing') }}" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-blue-100/20 dark:hover:bg-gray-700">
                    <svg class="h-6 w-6 {{ request()->is('admin/pamm/*') ? 'font-semibold text-lg text-blue-400' : 'font-semibold text-lg text-white'}}"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="18" r="2" />  <circle cx="7" cy="6" r="2" />  <circle cx="17" cy="6" r="2" />  <path d="M7 8v2a2 2 0 0 0 2 2h6a2 2 0 0 0 2 -2v-2" />  <line x1="12" y1="12" x2="12" y2="16" /></svg>
                    <span class="flex-1 ml-3 whitespace-nowrap {{ request()->is('admin/pamm/*') ? 'font-semibold text-lg text-blue-400' : 'font-semibold text-lg text-white'}}">@lang('public.pamm')</span>
                </a>
            </li>
            <li>
                <a href="{{ route('news_listing') }}" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-blue-100/20 dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 {{ request()->is('admin/news/*') ? 'text-blue-400' : 'text-white'}}">
                        <path fill-rule="evenodd" d="M4.125 3C3.089 3 2.25 3.84 2.25 4.875V18a3 3 0 003 3h15a3 3 0 01-3-3V4.875C17.25 3.839 16.41 3 15.375 3H4.125zM12 9.75a.75.75 0 000 1.5h1.5a.75.75 0 000-1.5H12zm-.75-2.25a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5H12a.75.75 0 01-.75-.75zM6 12.75a.75.75 0 000 1.5h7.5a.75.75 0 000-1.5H6zm-.75 3.75a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5H6a.75.75 0 01-.75-.75zM6 6.75a.75.75 0 00-.75.75v3c0 .414.336.75.75.75h3a.75.75 0 00.75-.75v-3A.75.75 0 009 6.75H6z" clip-rule="evenodd" />
                        <path d="M18.75 6.75h1.875c.621 0 1.125.504 1.125 1.125V18a1.5 1.5 0 01-3 0V6.75z" />
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap {{ request()->is('admin/news/*') ? 'font-semibold text-lg text-blue-400' : 'font-semibold text-lg text-white'}}">@lang('public.news')</span>
                </a>
            </li>
            <li>
                <a href="{{ route('event_listing') }}" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-blue-100/20 dark:hover:bg-gray-700">
                    <svg class="h-6 w-6 {{ request()->is('admin/event/*') ? 'text-blue-400' : 'text-white'}}"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <rect x="4" y="5" width="16" height="16" rx="2" />  <line x1="16" y1="3" x2="16" y2="7" />  <line x1="8" y1="3" x2="8" y2="7" />  <line x1="4" y1="11" x2="20" y2="11" />  <rect x="8" y="15" width="2" height="2" /></svg>
                    <span class="flex-1 ml-3 whitespace-nowrap {{ request()->is('admin/event/*') ? 'font-semibold text-lg text-blue-400' : 'font-semibold text-lg text-white'}}">@lang('public.event')</span>
                </a>
            </li>
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-white transition duration-75 rounded-lg group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-setting" data-collapse-toggle="dropdown-setting">
                    <svg class="h-6 w-6 {{ request()->is('admin/setting/*') ? 'text-blue-400' : 'text-white'}}"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />  <circle cx="12" cy="12" r="3" /></svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap {{ request()->is('admin/setting/*') ? 'font-semibold text-lg text-blue-400' : 'font-semibold text-lg text-white'}}" sidebar-toggle-item>@lang('public.setting')</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="dropdown-setting" class="{{ request()->is('admin/setting/*') ? '' : 'hidden' }} py-2 space-y-2">
                    <li>
                        <a href="{{ route('setting_listing') }}" class="{{ request()->is('admin/setting/setting_listing') || request()->is('admin/setting/setting_edit/*') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-blue-400">@lang('public.master_setting')</a>
                    </li>
                    <li>
                        <a href="{{ route('setting_withdrawal') }}" class="{{ request()->is('admin/setting/setting_withdrawal') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 text-base font-semibold transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-blue-400">@lang('public.withdrawal_action')</a>
                    </li>
                    <li>
                        <a href="{{ route('setting_email_status') }}" class="{{ request()->is('admin/setting/setting_email_status') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 text-base font-semibold transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-blue-400">@lang('public.email_status')</a>
                    </li>
                    <li>
                        <a href="{{ route('setting_lot_size') }}" class="{{ request()->is('admin/setting/setting_lot_size') ? 'text-sm font-semibold text-blue-400' : 'text-sm font-semibold text-white'}} flex items-center w-full p-2 text-base font-semibold transition duration-75 rounded-lg pl-11 group hover:bg-blue-100/20 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-blue-400">@lang('public.lot_size')</a>
                    </li>
                </ul>
            </li>
            <li>
                <form method="post" action="{{ url('logout') }}" class="inline-flex w-full whitespace-nowrap bg-transparent rounded-lg hover:bg-blue-100/20">
                    @csrf
                    <a href="javascript:void(0)" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white dark:hover:bg-gray-700">
                        <svg class="h-8 w-8 text-red-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />  <path d="M20 12h-13l3 -3m0 6l-3 -3" /></svg>
                        <button class="text-lg ml-1 text-rose-500 font-bold hover:text-rose-600">@lang('public.logout')</button>
                    </a>
                </form>
            </li>
        </ul>
    </div>
</aside>

