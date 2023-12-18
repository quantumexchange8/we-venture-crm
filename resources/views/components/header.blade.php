<div class="flex">
    <div class="flex ml-56 mt-8 max-[520px]:mx-4 max-[760px]:mx-auto">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-orange-400 max-[520px]:hidden">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3" />
        </svg>
        <h5 class="ml-2 text-xl font-semibold tracking-tight text-orange-500 dark:text-white {{ request()->is('member/welcome_page') ? 'hidden' : '' }}"><span class="max-[475px]:hidden"> @lang('public.wallet') </span>@lang('public.balance'): <span class="text-gray-700">${{Auth::user() ? Auth::user()->wallet_balance : 0.00}}</span></h5>
    </div>
    <div class="relative items-center inline-flex pt-6 ml-auto float-right mr-6 ">
        <!-- Icon -->

        <button id="dropdownDefaultButton" data-dropdown-toggle="dropdownLanguage" class="text-gray-500 font-bolded text-md px-4 py-2.5 text-center inline-flex items-center" type="button">
            @switch(app()->getLocale())
                @case('en')
                    <span class="fi fi-us mr-3 "></span>
                    EN
                    @break

                @case('cn')
                    <span class="fi fi-cn mr-3 "></span>
                    简体字
                    @break


                @case('tw')
                    <span class="fi fi-tw mr-3 "></span>
                    繁体字
                    @break

                @case('th')
                    <span class="fi fi-th mr-3 "></span>
                    Thailand
                    @break

                @case('id')
                    <span class="fi fi-id mr-3 "></span>
                    Indonesian
                    @break

                @case('vn')
                    <span class="fi fi-vn mr-3 "></span>
                    Việt Nam
                    @break

                @default
                    <span class="fi fi-us mr-3 "></span>
                    EN
            @endswitch
        </button>
        <div id="dropdownLanguage" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                <li>
                    <a href="{{ url('localization/en') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><span class="fi fi-us mr-3"></span>English</a>
                </li>
                <li>
                    <a href="{{ url('localization/cn') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><span class="fi fi-cn mr-3"></span>简体字</a>
                </li>
                <li>
                    <a href="{{ url('localization/tw') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><span class="fi fi-tw mr-3"></span>繁体字</a>
                </li>
                <li>
                    <a href="{{ url('localization/th') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><span class="fi fi-th mr-3"></span>ประเทศไทย</a>
                </li>
                <li>
                    <a href="{{ url('localization/id') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><span class="fi fi-id mr-3"></span>Indonesia</a>
                </li>
                <li>
                    <a href="{{ url('localization/vn') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><span class="fi fi-vn mr-3"></span>Việt Nam</a>
                </li>
            </ul>
        </div>


        <button id="dropdownprofile" data-dropdown-toggle="dropdownProfile" class="text-gray-500 font-bolded text-md text-center inline-flex items-center">
            <img
                @php
                    $user = Auth::user();
                @endphp
                @if ($user->profile_image)
                    src="{{ asset('uploads/users/' .$user->profile_image)}}"
                @else
                    src="{{url('/img/profile.png')}}"
                @endif
                class="rounded-full h-8 w-8 "
                alt=""
                loading="lazy" />
        </button>
        <div id="dropdownProfile" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownprofile">
                <li>
                    <a href="{{ url('member/change-password') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 mt-1 mr-2">
                            <path fill-rule="evenodd" d="M15.75 1.5a6.75 6.75 0 00-6.651 7.906c.067.39-.032.717-.221.906l-6.5 6.499a3 3 0 00-.878 2.121v2.818c0 .414.336.75.75.75H6a.75.75 0 00.75-.75v-1.5h1.5A.75.75 0 009 19.5V18h1.5a.75.75 0 00.53-.22l2.658-2.658c.19-.189.517-.288.906-.22A6.75 6.75 0 1015.75 1.5zm0 3a.75.75 0 000 1.5A2.25 2.25 0 0118 8.25a.75.75 0 001.5 0 3.75 3.75 0 00-3.75-3.75z" clip-rule="evenodd" />
                        </svg>@lang('public.change_password')
                    </a>
                </li>
                <li>
                    @if( session('impersonate-admin-id'))
                        <form method="post" action="{{ route('leave_impersonate_user') }}"
                              class="inline-flex w-full whitespace-nowrap bg-transparent py-2 px-4 text-sm font-normal text-rose-500 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-white/30"
                              data-te-dropdown-item-ref>@csrf
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 mt-0.5 mr-2">
                                <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6zm10.72 4.72a.75.75 0 011.06 0l3 3a.75.75 0 010 1.06l-3 3a.75.75 0 11-1.06-1.06l1.72-1.72H9a.75.75 0 010-1.5h10.94l-1.72-1.72a.75.75 0 010-1.06z" clip-rule="evenodd" />
                            </svg><button>@lang('public.leave_impersonate')</button>
                        </form>
                    @else
                        <form method="post" action="{{ url('logout') }}"
                              class="inline-flex w-full whitespace-nowrap bg-transparent py-2 px-4 text-sm font-normal text-rose-500 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-white/30"
                              data-te-dropdown-item-ref>@csrf
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 mt-0.5 mr-2">
                                <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6zm10.72 4.72a.75.75 0 011.06 0l3 3a.75.75 0 010 1.06l-3 3a.75.75 0 11-1.06-1.06l1.72-1.72H9a.75.75 0 010-1.5h10.94l-1.72-1.72a.75.75 0 010-1.06z" clip-rule="evenodd" />
                            </svg><button>@lang('public.logout')</button>
                        </form>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</div>
