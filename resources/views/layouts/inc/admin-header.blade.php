<div class="flex">
    <div class="relative items-center inline-flex pt-6 ml-auto float-right text-sm mr-6">
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
                    <a href="{{ url('localization/th') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><span class="fi fi-th mr-3"></span>ประเทศไทย </a>
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
                class="rounded-full h-8 w-8"
                loading="lazy" />
        </button>
        <div id="dropdownProfile" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownprofile">
                <li>
                    <a href="{{ route('admin_profile') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                        </svg>
                        <span class="ml-1">@lang('public.profile')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin_change_password') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M8 7a5 5 0 113.61 4.804l-1.903 1.903A1 1 0 019 14H8v1a1 1 0 01-1 1H6v1a1 1 0 01-1 1H3a1 1 0 01-1-1v-2a1 1 0 01.293-.707L8.196 8.39A5.002 5.002 0 018 7zm5-3a.75.75 0 000 1.5A1.5 1.5 0 0114.5 7 .75.75 0 0016 7a3 3 0 00-3-3z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-1">@lang('public.change_password')</span>
                    </a>
                </li>
                <li>
                    <form method="post" action="{{ url('logout') }}"
                          class="inline-flex w-full whitespace-nowrap bg-transparent py-2 px-4 text-sm font-normal text-rose-500 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-white/30"
                          data-te-dropdown-item-ref>@csrf
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 mt-0.5 mr-2">
                            <path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6zm10.72 4.72a.75.75 0 011.06 0l3 3a.75.75 0 010 1.06l-3 3a.75.75 0 11-1.06-1.06l1.72-1.72H9a.75.75 0 010-1.5h10.94l-1.72-1.72a.75.75 0 010-1.06z" clip-rule="evenodd" />
                        </svg>
                        <button>@lang('public.logout')</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
