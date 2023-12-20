@extends('layouts.master-member')

@section('title') Dashboard @endsection

@section('contents')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="w-full p-4 text-center bg-blue-100 border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-2 text-2xl font-bold text-blue-500 dark:text-white">@lang('public.lot_size_pool') (UM)</h5>
            <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                <h3 class="mb-2 text-3xl font-extrabold text-[#696057]">
                    $ {{ number_format(\App\Models\Commissions::getLotSizePool(), 2) }}
                </h3>
            </div>
        </div>

        <div class="w-full p-4 text-center bg-blue-100 border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-2 text-2xl font-bold text-blue-500 dark:text-white">@lang('public.lot_size_pool') (RM)</h5>
            <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                <h3 class="mb-2 text-3xl font-extrabold text-[#696057]">
                    $ {{ number_format(\App\Models\Commissions::getLotSizePool() * 2, 2) }}
                </h3>
            </div>
        </div>
    </div>


        <div class="grid grid-flow-row grid-flow-cols grid-cols-3 gap-6 my-4 max-[1250px]:grid-rows-auto max-[1320px]:grid-cols-2 max-[1000px]:grid-cols-1">
            <div class="flex justify-center max-[1320px]:justify-start ">
                <div
                    class="block rounded-lg bg-blue-100 text-center shadow-lg dark:bg-neutral-700 w-full border-2">
                    <div
                        class="border-b-2 border-neutral-100 py-6 px-6 dark:border-neutral-600 dark:text-neutral-50 flex justify-center text-blue-500 font-bold text-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                             class="w-6 h-6 mr-3 mt-1">
                            <path fill-rule="evenodd"
                                  d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM9.624 7.084a.75.75 0 00-1.248.832l2.223 3.334H9a.75.75 0 000 1.5h2.25v1.5H9a.75.75 0 000 1.5h2.25v1.5a.75.75 0 001.5 0v-1.5H15a.75.75 0 000-1.5h-2.25v-1.5H15a.75.75 0 000-1.5h-1.599l2.223-3.334a.75.75 0 10-1.248-.832L12 10.648 9.624 7.084z"
                                  clip-rule="evenodd"/>
                        </svg>
                        @lang('public.personal_deposit')
                    </div>
                    <div class="w-full max-w-md p-6 mx-auto bg-blue-100">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="my-2 text-xl text-[#696057] font-bold leading-none dark:text-white">
                                @lang('public.total'): ${{number_format($personal_total,2)}}
                            </h5>
                            <a href="javascript:void(0)" class="font-medium text-blue-600 hover:underline dark:text-blue-500" data-modal-target="personalModal" data-modal-toggle="personalModal" data-te-ripple-init data-te-ripple-color="light">
                                @lang('public.more')
                            </a>
                        </div>
                        <div class="flow-root">
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($deposits->slice(0, 2) as $deposit)
                                    <li class="py-3 sm:py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-1 min-w-0">
                                                <p class="text-left text-sm font-bold text-blue-500 truncate dark:text-white">
                                                    {{$deposit->broker->name}}
                                                </p>
                                            </div>
                                            <div class="inline-flex items-center text-sm font-semibold text-[#696057] dark:text-white">
                                                ${{number_format($deposit->amount,2)}}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center max-[1320px]:justify-start">
                <div
                    class="block rounded-lg bg-blue-100 text-center shadow-lg dark:bg-neutral-700 w-full border-2">
                    <div
                        class="border-b-2 border-neutral-100 py-6 px-6 dark:border-neutral-600 dark:text-neutral-50 flex justify-center text-blue-500 font-bold text-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                             class="w-6 h-6 mr-3 mt-1">
                            <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z"/>
                            <path fill-rule="evenodd"
                                  d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 14.625v-9.75zM8.25 9.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM18.75 9a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V9.75a.75.75 0 00-.75-.75h-.008zM4.5 9.75A.75.75 0 015.25 9h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V9.75z"
                                  clip-rule="evenodd"/>
                            <path
                                d="M2.25 18a.75.75 0 000 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 00-.75-.75H2.25z"/>
                        </svg>
                        @lang('public.group_deposit')
                    </div>
                    <div class="w-full max-w-md p-6 mx-auto bg-blue-100">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="my-2 text-xl text-[#696057] font-bold leading-none dark:text-white">
                                @lang('public.total'): ${{number_format($group_deposits_total,2)}}
                            </h5>
                            <a href="javascript:void(0)" class="font-medium text-blue-600 hover:underline dark:text-blue-500" data-te-toggle="modal"
                               data-te-target="#groupDepositModal"
                               data-te-ripple-init
                               data-te-ripple-color="light">
                                @lang('public.more')
                            </a>
                        </div>
                        <div class="flow-root">
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($group_deposits->slice(0,2) as $group_deposit)
                                    <li class="py-3 sm:py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-1 min-w-0">
                                                <p class="text-left text-sm font-bold text-blue-500 truncate dark:text-white">
                                                    {{$group_deposit->name}}
                                                </p>
                                            </div>
                                            <div class="inline-flex items-center text-sm font-semibold text-[#696057] dark:text-white">
                                                ${{number_format($group_deposit->total,2)}}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center max-[1320px]:justify-start max-[1000px]:h-auto">
                <div class="p-4 block rounded-lg bg-blue-100 text-center shadow-lg dark:bg-neutral-700 w-full border-2">
                    <h4 class="px-12 text-xl font-bold leading-tight text-[#696057] dark:text-neutral-50 max-lg:hidden">
                        {{$user->name}}
                    </h4>
                    <div class="border-b-2 border-neutral-200 py-4 px-4 dark:border-neutral-600 dark:text-neutral-50 flex justify-center text-blue-500 font-bold text-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                             class="w-6 h-6 mr-3 mt-1">
                            <path fill-rule="evenodd"
                                  d="M5.166 2.621v.858c-1.035.148-2.059.33-3.071.543a.75.75 0 00-.584.859 6.753 6.753 0 006.138 5.6 6.73 6.73 0 002.743 1.346A6.707 6.707 0 019.279 15H8.54c-1.036 0-1.875.84-1.875 1.875V19.5h-.75a2.25 2.25 0 00-2.25 2.25c0 .414.336.75.75.75h15a.75.75 0 00.75-.75 2.25 2.25 0 00-2.25-2.25h-.75v-2.625c0-1.036-.84-1.875-1.875-1.875h-.739a6.706 6.706 0 01-1.112-3.173 6.73 6.73 0 002.743-1.347 6.753 6.753 0 006.139-5.6.75.75 0 00-.585-.858 47.077 47.077 0 00-3.07-.543V2.62a.75.75 0 00-.658-.744 49.22 49.22 0 00-6.093-.377c-2.063 0-4.096.128-6.093.377a.75.75 0 00-.657.744zm0 2.629c0 1.196.312 2.32.857 3.294A5.266 5.266 0 013.16 5.337a45.6 45.6 0 012.006-.343v.256zm13.5 0v-.256c.674.1 1.343.214 2.006.343a5.265 5.265 0 01-2.863 3.207 6.72 6.72 0 00.857-3.294z"
                                  clip-rule="evenodd"/>
                        </svg>
                        @lang('public.'. $rank->rank_short_form )
                    </div>
                    <div class="py-3 ">
                        <div class="flow-root">
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                <li class="py-3 sm:py-4">
                                    <div class="flex items-center space-x-4 text-sm">
                                        <div class="flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                 class="w-6 h-6 text-blue-500">
                                                <path
                                                    d="M2.273 5.625A4.483 4.483 0 015.25 4.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 3H5.25a3 3 0 00-2.977 2.625zM2.273 8.625A4.483 4.483 0 015.25 7.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 6H5.25a3 3 0 00-2.977 2.625zM5.25 9a3 3 0 00-3 3v6a3 3 0 003 3h13.5a3 3 0 003-3v-6a3 3 0 00-3-3H15a.75.75 0 00-.75.75 2.25 2.25 0 01-4.5 0A.75.75 0 009 9H5.25z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0 text-left">
                                            <p class="text-blue-500 font-semibold truncate dark:text-white">
                                                @lang('public.personal_daily_deposit')
                                            </p>
                                        </div>
                                        <div class="inline-flex items-center font-semibold text-[#696057] dark:text-white">
                                            ${{number_format($user->userDailyMonthlyDeposit(), 2)}}
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4 text-sm">
                                        <div class="flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                 class="w-6 h-6 text-blue-500">
                                                <path
                                                    d="M2.273 5.625A4.483 4.483 0 015.25 4.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 3H5.25a3 3 0 00-2.977 2.625zM2.273 8.625A4.483 4.483 0 015.25 7.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 6H5.25a3 3 0 00-2.977 2.625zM5.25 9a3 3 0 00-3 3v6a3 3 0 003 3h13.5a3 3 0 003-3v-6a3 3 0 00-3-3H15a.75.75 0 00-.75.75 2.25 2.25 0 01-4.5 0A.75.75 0 009 9H5.25z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0 text-left">
                                            <p class="text-blue-500 font-semibold truncate dark:text-white">
                                                @lang('public.personal_monthly_deposit')
                                            </p>
                                        </div>
                                        <div class="inline-flex items-center font-semibold text-[#696057] dark:text-white">
                                            ${{number_format($user->userDailyMonthlyDeposit(true), 2)}}
                                        </div>
                                    </div>

                                </li>
                                <li class="py-3 sm:py-4">
                                    <div class="flex items-center space-x-4 text-sm">
                                        <div class="flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                 class="w-6 h-6 text-blue-500">
                                                <path
                                                    d="M2.273 5.625A4.483 4.483 0 015.25 4.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 3H5.25a3 3 0 00-2.977 2.625zM2.273 8.625A4.483 4.483 0 015.25 7.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 6H5.25a3 3 0 00-2.977 2.625zM5.25 9a3 3 0 00-3 3v6a3 3 0 003 3h13.5a3 3 0 003-3v-6a3 3 0 00-3-3H15a.75.75 0 00-.75.75 2.25 2.25 0 01-4.5 0A.75.75 0 009 9H5.25z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0 text-left">
                                            <p class="text-blue-500 font-semibold truncate dark:text-white">
                                                @lang('public.group_daily_deposit')
                                            </p>
                                        </div>
                                        <div class="inline-flex items-center font-semibold text-[#696057] dark:text-white">
                                            ${{number_format($user->groupDailyMonthlyDeposit(), 2)}}
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4 text-sm">
                                        <div class="flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                 class="w-6 h-6 text-blue-500">
                                                <path
                                                    d="M2.273 5.625A4.483 4.483 0 015.25 4.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 3H5.25a3 3 0 00-2.977 2.625zM2.273 8.625A4.483 4.483 0 015.25 7.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 6H5.25a3 3 0 00-2.977 2.625zM5.25 9a3 3 0 00-3 3v6a3 3 0 003 3h13.5a3 3 0 003-3v-6a3 3 0 00-3-3H15a.75.75 0 00-.75.75 2.25 2.25 0 01-4.5 0A.75.75 0 009 9H5.25z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0 text-left">
                                            <p class="text-blue-500 font-semibold truncate dark:text-white">
                                                @lang('public.group_daily_withdrawal')
                                            </p>
                                        </div>
                                        <div class="inline-flex items-center font-semibold text-[#696057] dark:text-white">
                                            ${{number_format($user->groupDailyMonthlyWithdrawal(), 2)}}
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4 text-sm">
                                        <div class="flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                 class="w-6 h-6 text-blue-500">
                                                <path
                                                    d="M2.273 5.625A4.483 4.483 0 015.25 4.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 3H5.25a3 3 0 00-2.977 2.625zM2.273 8.625A4.483 4.483 0 015.25 7.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 6H5.25a3 3 0 00-2.977 2.625zM5.25 9a3 3 0 00-3 3v6a3 3 0 003 3h13.5a3 3 0 003-3v-6a3 3 0 00-3-3H15a.75.75 0 00-.75.75 2.25 2.25 0 01-4.5 0A.75.75 0 009 9H5.25z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0 text-left">
                                            <p class="text-blue-500 font-semibold truncate dark:text-white">
                                                @lang('public.group_monthly_deposit')
                                            </p>
                                        </div>
                                        <div class="inline-flex items-center font-semibold text-[#696057] dark:text-white">
                                            ${{number_format($user->groupDailyMonthlyDeposit(true), 2)}}
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4 text-sm">
                                        <div class="flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                 class="w-6 h-6 text-blue-500">
                                                <path
                                                    d="M2.273 5.625A4.483 4.483 0 015.25 4.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 3H5.25a3 3 0 00-2.977 2.625zM2.273 8.625A4.483 4.483 0 015.25 7.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0018.75 6H5.25a3 3 0 00-2.977 2.625zM5.25 9a3 3 0 00-3 3v6a3 3 0 003 3h13.5a3 3 0 003-3v-6a3 3 0 00-3-3H15a.75.75 0 00-.75.75 2.25 2.25 0 01-4.5 0A.75.75 0 009 9H5.25z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0 text-left">
                                            <p class="text-blue-500 font-semibold truncate dark:text-white">
                                                @lang('public.group_monthly_withdrawal')
                                            </p>
                                        </div>
                                        <div class="inline-flex items-center font-semibold text-[#696057] dark:text-white">
                                            ${{number_format($user->groupDailyMonthlyWithdrawal(true), 2)}}
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center col-span-2 ">
                <div class="px-6 block rounded-lg bg-blue-100  shadow-lg dark:bg-neutral-700 w-full border-2">
                    <div class="inline-flex items-center w-full gap-2 justify-center pt-6 text-blue-500 font-bold text-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75h-.75v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75h-.75v-.75z"/>
                        </svg>
                        @lang('public.referral_program')
                    </div>
                    <div>

                    </div>
                    <p class="my-2 text-center text-base text-neutral-600 dark:text-neutral-200">
                        @lang('public.share_referral')
                    </p>
                    <div class="mx-4 my-3">
                        <div class="py-4 px-2 flex flex-col gap-4 items-center justify-center">
                            <p class="text-lg text-neutral-600 dark:text-neutral-200 font-medium ">
                                @lang('public.referral_id'): <span class="text-blue-500 font-semibold">{{$user->referral_id}}</span>
                            </p>
                            {{ QrCode::size(180)->generate($user->url) }}
                            <div class="flex w-full">
                                <button id="copyLink"
                                        class="inline-flex items-center px-3 text-sm text-blue-500 bg-blue-200 border border-r-0 border-blue-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/>
                                    </svg>
                                </button>
                                <input id="refLink" type="text" id="website-admin"
                                       value="{{ $user->url }}"
                                       class="select-all rounded-none rounded-r-lg bg-blue-50 border text-blue-500 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 text-sm border-blue-300 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="elonmusk" disabled>
                            </div>
                        </div>


{{--                            <div class="mt-3">--}}
{{--                                <button type="button"--}}
{{--                                        onclick=" window.open('{{$shareFB}}','_blank')"--}}
{{--                                        class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">--}}
{{--                                    <svg class="w-6 h-6" viewBox="0 0 48 48" fill="none"--}}
{{--                                         xmlns="http://www.w3.org/2000/svg">--}}
{{--                                        <path--}}
{{--                                            d="M36 12.5997H31.2489H29.9871C28.9009 12.5997 28.0203 13.4803 28.0203 14.5666V21.4674H36L34.8313 29.0643H28.0203V43H19.2451V29.0643H12V21.4674H19.1515L19.2451 14.2563L19.2318 12.9471C19.1879 8.60218 22.6745 5.04434 27.0194 5.0004C27.0459 5.00013 27.0724 5 27.0989 5H36V12.5997Z"--}}
{{--                                            fill="#ffffff" stroke="#ffffff" stroke-width="2" stroke-linejoin="round"/>--}}
{{--                                    </svg>--}}
{{--                                </button>--}}
{{--                                <button type="button"--}}
{{--                                        onclick=" window.open('{{$shareTwitter}}','_blank')"--}}
{{--                                        class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">--}}
{{--                                    <svg class="w-6 h-6" viewBox="0 0 48 48" fill="none"--}}
{{--                                         xmlns="http://www.w3.org/2000/svg">--}}
{{--                                        <path--}}
{{--                                            d="M5 35.7622C6.92886 36.8286 20.8914 44.8773 30.8199 38.674C40.7483 32.4707 40.2006 21.7833 40.2006 16.886C41.1 15.0018 43 14.0439 43 8.9438C41.1337 10.6678 39.2787 11.2544 37.435 10.7036C35.6287 7.94957 33.1435 6.73147 29.9794 7.04934C25.2333 7.52614 23.4969 12.1825 24.0079 18.2067C16.6899 21.9074 10.9515 15.524 7.99418 10.7036C7.00607 14.4999 6.0533 19.0576 7.99418 24.0995C9.2881 27.4607 12.3985 30.3024 17.3254 32.6246C12.3323 35.3308 8.22382 36.3766 5 35.7622Z"--}}
{{--                                            fill="#ffffff" stroke="#ffffff" stroke-width="2" stroke-linejoin="round"/>--}}
{{--                                    </svg>--}}
{{--                                </button>--}}
{{--                                <button type="button"--}}
{{--                                        onclick=" window.open('{{$shareTelegram}}','_blank')"--}}
{{--                                        class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">--}}
{{--                                    <svg class="w-6 h-6" viewBox="0 0 48 48" fill="none"--}}
{{--                                         xmlns="http://www.w3.org/2000/svg">--}}
{{--                                        <path--}}
{{--                                            d="M41.4193 7.30899C41.4193 7.30899 45.3046 5.79399 44.9808 9.47328C44.8729 10.9883 43.9016 16.2908 43.1461 22.0262L40.5559 39.0159C40.5559 39.0159 40.3401 41.5048 38.3974 41.9377C36.4547 42.3705 33.5408 40.4227 33.0011 39.9898C32.5694 39.6652 24.9068 34.7955 22.2086 32.4148C21.4531 31.7655 20.5897 30.4669 22.3165 28.9519L33.6487 18.1305C34.9438 16.8319 36.2389 13.8019 30.8426 17.4812L15.7331 27.7616C15.7331 27.7616 14.0063 28.8437 10.7686 27.8698L3.75342 25.7055C3.75342 25.7055 1.16321 24.0823 5.58815 22.459C16.3807 17.3729 29.6555 12.1786 41.4193 7.30899Z"--}}
{{--                                            fill="#ffffff"/>--}}
{{--                                    </svg>--}}
{{--                                </button>--}}
{{--                                <button type="button"--}}
{{--                                        onclick=" window.open('{{$shareWA}}','_blank')"--}}
{{--                                        class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" class="w-6 h-6"--}}
{{--                                         viewBox="0,0,256,256" style="fill:#000000;">--}}
{{--                                        <g fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1"--}}
{{--                                           stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10"--}}
{{--                                           stroke-dasharray="" stroke-dashoffset="0" font-family="none"--}}
{{--                                           font-weight="none" font-size="none" text-anchor="none"--}}
{{--                                           style="mix-blend-mode: normal">--}}
{{--                                            <g transform="scale(8.53333,8.53333)">--}}
{{--                                                <path--}}
{{--                                                    d="M15,3c-6.627,0 -12,5.373 -12,12c0,2.25121 0.63234,4.35007 1.71094,6.15039l-1.60352,5.84961l5.97461,-1.56836c1.74732,0.99342 3.76446,1.56836 5.91797,1.56836c6.627,0 12,-5.373 12,-12c0,-6.627 -5.373,-12 -12,-12zM10.89258,9.40234c0.195,0 0.39536,-0.00119 0.56836,0.00781c0.214,0.005 0.44692,0.02067 0.66992,0.51367c0.265,0.586 0.84202,2.05608 0.91602,2.20508c0.074,0.149 0.12644,0.32453 0.02344,0.51953c-0.098,0.2 -0.14897,0.32105 -0.29297,0.49805c-0.149,0.172 -0.31227,0.38563 -0.44727,0.51563c-0.149,0.149 -0.30286,0.31238 -0.13086,0.60938c0.172,0.297 0.76934,1.27064 1.65234,2.05664c1.135,1.014 2.09263,1.32561 2.39063,1.47461c0.298,0.149 0.47058,0.12578 0.64258,-0.07422c0.177,-0.195 0.74336,-0.86411 0.94336,-1.16211c0.195,-0.298 0.39406,-0.24644 0.66406,-0.14844c0.274,0.098 1.7352,0.8178 2.0332,0.9668c0.298,0.149 0.49336,0.22275 0.56836,0.34375c0.077,0.125 0.07708,0.72006 -0.16992,1.41406c-0.247,0.693 -1.45991,1.36316 -2.00391,1.41016c-0.549,0.051 -1.06136,0.24677 -3.56836,-0.74023c-3.024,-1.191 -4.93108,-4.28828 -5.08008,-4.48828c-0.149,-0.195 -1.21094,-1.61031 -1.21094,-3.07031c0,-1.465 0.76811,-2.18247 1.03711,-2.48047c0.274,-0.298 0.59492,-0.37109 0.79492,-0.37109z"></path>--}}
{{--                                            </g>--}}
{{--                                        </g>--}}
{{--                                    </svg>--}}
{{--                                </button>--}}
{{--                            </div>--}}
                    </div>
                </div>
            </div>
            <!-- <div class="flex justify-center max-[1320px]:justify-start max-[1000px]:col-span-1 max-[1320px]:col-span-2 ">
                <div class="block rounded-lg bg-blue-100 shadow-lg dark:bg-neutral-700 w-full border-2">
                    <div class="py-6 px-6 dark:border-neutral-600 dark:text-neutral-50 inline-flex items-center w-full gap-2 justify-center text-blue-500 font-bold text-xl">
                        <svg class="h-6 w-6 text-blue-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <polyline points="8 12 12 16 16 12" />  <line x1="12" y1="8" x2="12" y2="16" /></svg>
                        @lang('public.download_app')
                    </div>
                    <div class="flow-root px-6">
                        <a href="{{ $app_download_link }}" target="_blank" class="flex justify-center my-4 w-full">
                            <button
                                type="button"
                                class=" text-white bg-blue-500 border border-blue-600 hover:bg-blue-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                id="downloadAPK"
                            >
                                <svg class="h-6 w-6 mr-1 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />  <polyline points="7 11 12 16 17 11" />  <line x1="12" y1="4" x2="12" y2="16" /></svg>
                                @lang('public.download_app')
                            </button>
                        </a>
                        <div class="mt-4 text-[#696057]">
                            @lang('public.app_note')
                        </div>
                    </div>

                </div>
            </div> -->
            <div class="flex justify-center max-[1000px]:justify-end max-[1320px]:col-span-2">
                <div class="block rounded-lg bg-blue-100 shadow-lg dark:bg-neutral-700 w-full border-2">
                    <div class="border-b-2 border-neutral-100 py-6 px-6 dark:border-neutral-600 dark:text-neutral-50 flex justify-center text-blue-500 font-bold text-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                             class="w-6 h-6 mr-3 mt-1">
                            <path fill-rule="evenodd"
                                  d="M4.125 3C3.089 3 2.25 3.84 2.25 4.875V18a3 3 0 003 3h15a3 3 0 01-3-3V4.875C17.25 3.839 16.41 3 15.375 3H4.125zM12 9.75a.75.75 0 000 1.5h1.5a.75.75 0 000-1.5H12zm-.75-2.25a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5H12a.75.75 0 01-.75-.75zM6 12.75a.75.75 0 000 1.5h7.5a.75.75 0 000-1.5H6zm-.75 3.75a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5H6a.75.75 0 01-.75-.75zM6 6.75a.75.75 0 00-.75.75v3c0 .414.336.75.75.75h3a.75.75 0 00.75-.75v-3A.75.75 0 009 6.75H6z"
                                  clip-rule="evenodd"/>
                            <path d="M18.75 6.75h1.875c.621 0 1.125.504 1.125 1.125V18a1.5 1.5 0 01-3 0V6.75z"/>
                        </svg>
                        @lang('public.news_and_announcement')
                    </div>
                    <div class="flow-root px-6">
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($news_all as $news)
                                <li class="py-3 sm:py-4 hover:bg-blue-100">
                                    <a href="javascript:void(0)" class="w-full" data-te-toggle="modal"
                                       data-te-target="#newsModal-{{ $news->id }}"
                                       data-te-ripple-init
                                       data-te-ripple-color="light">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0 text-sm text-gray-500">
                                                {{ date('d-m-Y', strtotime($news->created_at)) }}
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-primary-600 break-words dark:text-white">
                                                    {{ $news->title }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                @include('components.member_news_modal')
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        <!-- Personal Deposit Modal -->
        <div id="personalModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
            <div class="relative w-full h-full max-w-2xl md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-6 border-b rounded-t dark:border-gray-600 text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                             class="w-6 h-6 mr-3 mt-1">
                            <path fill-rule="evenodd"
                                  d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM9.624 7.084a.75.75 0 00-1.248.832l2.223 3.334H9a.75.75 0 000 1.5h2.25v1.5H9a.75.75 0 000 1.5h2.25v1.5a.75.75 0 001.5 0v-1.5H15a.75.75 0 000-1.5h-2.25v-1.5H15a.75.75 0 000-1.5h-1.599l2.223-3.334a.75.75 0 10-1.248-.832L12 10.648 9.624 7.084z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <h3 class="text-xl font-semibold dark:text-white ">
                            @lang('public.personal_deposit')
                        </h3>

                        <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="personalModal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">@lang('public.close_modal')</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="px-6 py-4 space-y-6 overflow-auto">
                        <div class="flow-root">
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                @if($deposits->count() > 0)
                                    @foreach($deposits as $deposit)
                                        <li class="py-3 sm:py-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-shrink-0">
                                                    @if ($deposit->broker->broker_image)
                                                        <img src="{{ asset('uploads/brokers/' .$deposit->broker->broker_image)}}" class="w-10 h-10 rounded-full bg-gray-100" alt="">
                                                    @else
                                                        <img class="w-10 h-10 rounded-full bg-gray-100" alt="">
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0 text-left">
                                                    <p class="text-blue-500 font-semibold truncate dark:text-white">
                                                        {{$deposit->broker->name}}
                                                    </p>
                                                </div>
                                                <div class="inline-flex items-center text-base font-semibold text-[#696057] dark:text-white">
                                                    ${{number_format($deposit->amount,2)}}
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    <li>
                                        <div class="w-full flex p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-500 dark:border-blue-800" role="alert">
                                            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                            <span class="sr-only">@lang('public.info')</span>
                                            <div>
                                                <span class="font-medium">@lang('public.info'):</span> @lang('public.no_record')
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                            <div class="flex items-center float-right mt-4">
                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    <p class="font-bold text-xl text-blue-500">@lang('public.total'): ${{number_format($personal_total,2)}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Group Deposit Modal -->
        <div
            data-te-modal-init
            class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
            id="groupDepositModal"
            tabindex="-1"
            aria-labelledby="groupDepositModalLabel"
            aria-hidden="true">
            <div
                data-te-modal-dialog-ref
                class="pointer-events-none relative h-[calc(100%-1rem)] w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:h-[calc(100%-3.5rem)] min-[576px]:max-w-2xl">
                <div
                    class="pointer-events-auto relative flex max-h-[100%] w-full flex-col overflow-hidden rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
                    <div
                        class="flex flex-shrink-0 items-center justify-between text-blue-500 rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                             class="w-6 h-6 mr-3 mt-1">
                            <path d="M12 7.5a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z"/>
                            <path fill-rule="evenodd"
                                  d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 011.5 14.625v-9.75zM8.25 9.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM18.75 9a.75.75 0 00-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 00.75-.75V9.75a.75.75 0 00-.75-.75h-.008zM4.5 9.75A.75.75 0 015.25 9h.008a.75.75 0 01.75.75v.008a.75.75 0 01-.75.75H5.25a.75.75 0 01-.75-.75V9.75z"
                                  clip-rule="evenodd"/>
                            <path
                                d="M2.25 18a.75.75 0 000 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 00-.75-.75H2.25z"/>
                        </svg>
                        <h3 class="text-xl font-semibold dark:text-white ">
                            @lang('public.group_deposit')
                        </h3>
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
                                class="h-6 w-6">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="relative overflow-y-auto p-4">
                        <div class="flow-root">
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                @if($group_deposits->count() > 0)
                                    @foreach ($group_deposits as $group_deposit)
                                        <li class="py-3 sm:py-4 accordion-flush-{{$group_deposit->id}}" data-accordion="collapse" data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white" data-inactive-classes="text-gray-500 dark:text-gray-400">
                                            <a href="javascript:void(0)" id="accordion-flush-heading-{{$group_deposit->id}}">
                                                <div class="flex items-center space-x-4" data-accordion-target="#accordion-flush-body-{{$group_deposit->id}}" aria-expanded="true" aria-controls="accordion-flush-body-{{$group_deposit->id}}">
                                                    <div class="flex-shrink-0">
                                                        @if ($group_deposit->profile_image)
                                                            <img src="{{ asset('uploads/users/' .$group_deposit->profile_image)}}" class="w-10 h-10 rounded-full bg-red-400" alt="">
                                                        @else
                                                            <img src="{{url('/img/profile.png')}}" class="w-10 h-10 rounded-full bg-blue-500" alt="">
                                                        @endif
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="font-semibold text-blue-500 text-md break-words">
                                                            {{$group_deposit->name}}
                                                        </p>
                                                    </div>
                                                    <div class="inline-flex items-center text-base font-semibold text-[#696057] dark:text-white">
                                                        ${{number_format($group_deposit->total,2)}}
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <div id="accordion-flush-body-{{$group_deposit->id}}" class="hidden" aria-labelledby="accordion-flush-heading-{{$group_deposit->id}}">
                                            @foreach($group_deposit->deposits as $deposit)
                                                <li class="pl-6 py-2 sm:py-3">
                                                    <div class="flex items-center space-x-4">
                                                        <div class="flex-shrink-0">
                                                            @if ($deposit['broker']['broker_image'])
                                                                <img src="{{ asset('uploads/brokers/' .$deposit['broker']['broker_image'])}}" class="w-10 h-10 rounded-full bg-gray-100" alt="">
                                                            @else
                                                                <img class="w-10 h-10 rounded-full bg-gray-100" alt="">
                                                            @endif
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-md text-[#C8C0B4] font-semibold break-words">
                                                                {{ $deposit['broker']['name'] }}
                                                            </p>
                                                        </div>
                                                        <div class="inline-flex items-center text-sm font-semibold text-[#696057] dark:text-white">
                                                            ${{number_format($deposit['amount'],2) }}
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </div>
                                    @endforeach
                                @else
                                    <li>
                                        <div class="w-full flex p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-500 dark:border-blue-800" role="alert">
                                            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                            <span class="sr-only">@lang('public.info')</span>
                                            <div>
                                                <span class="font-medium">@lang('public.info'):</span> @lang('public.no_record')
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div
                        class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                        <div class="flex items-center float-right mt-4">
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                <p class="font-bold text-xl text-blue-500">@lang('public.total'): ${{number_format($group_deposits_total,2)}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="popModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 backdrop-blur hidden p-4 mx-auto overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
            <div class="relative w-full h-full mx-auto max-w-2xl md:h-auto">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" onclick="closeNewsModal()">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    @foreach($news_all as $news)
                        @if($news->popup_status)
                        <div class="p-8 odd:bg-gray-100 even:bg-white rounded-l border border-gray-300">
                            <h3 class="text-xl font-semibold text-[#3F83F8] dark:text-white underline">
                                {{ $news->title }}
                            </h3>
                            <span class="text-xs font-semibold text-gray-500">{{ $news->created_at }}</span>
                            <div class="mt-6 text-base leading-relaxed text-gray-500 dark:text-gray-400 block">
                                {!! $news->content !!}
                                @if($news->hasMedia('news_image'))
                                    <div class="mt-6 flex justify-center">
                                        <figure class="max-w-lg">
                                            <img class="h-auto max-w-full rounded-lg" src="{{ $news->getFirstMediaUrl('news_image') }}" alt="image description">
                                        </figure>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>



@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){
            var copyText = document.getElementById("refLink");
            var  first_time= "<?php echo $first_time_logged_in; ?>";
            if (first_time == 1) {
                @if(!empty($news_all->count() > 0))
                    $('#popModal').show();
                    {{Session::put('first_time_logged_in', 0)}};
                @endif
            }

            $("#copyLink").click(function(){
                copyText.select();
                copyText.setSelectionRange(0, 99999); // For mobile devices

                // Copy the text inside the text field
                navigator.clipboard.writeText(copyText.value);

                // Alert the copied text
                Swal.fire({
                    title: "{{ trans('public.success') }}",
                    text: "{{ trans('public.link_copied') }}",
                    icon: 'success',
                    confirmButtonText: 'OK'
                })
            });
        });
        function closeNewsModal() {
            $('#popModal').hide();
        }

    </script>
@endsection
