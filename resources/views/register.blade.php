@extends('layouts.master-without-nav')

@section('title') Register @endsection

@section('css')
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet" />
@endsection

@section('contents')
    <div class="p-6 space-y-4 md:space-y-6 sm:p-8 bg-blue-100 rounded-lg">
        <button id="dropdownDefaultButton" data-dropdown-toggle="dropdownLanguage" class="text-gray-500 font-bolded text-md px-4 py-2.5 float-right" type="button">
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
        <a href="javascript:void(0)" class="flex justify-center my-4 items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
            <img class="h-20 mr-2" src="{{asset('img/WV-icon.png')}}" alt="logo">
        </a>
        <h1 class="text-xl font-bold leading-tight tracking-tight md:text-2xl dark:text-white text-gray-900">@lang('public.register_here')</h1>
        <p class="font-medium mb-6 text-gray-500">@lang('public.register_des')</p>

        <form method="post" action="{{ url('register') }}">@csrf

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="name" class="block mb-2 font-semibold text-blue-500">@lang('public.name')</label>
                    <input type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('name') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" @if(old('name')) value="{{ old('name') }}" @endif placeholder="@lang('public.name')">
                    @error('name')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block mb-2 font-semibold text-blue-500">@lang('public.email_address')</label>
                    <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('email') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" @if(old('email')) value="{{ old('email') }}" @endif placeholder="@lang('public.email_address')">
                    @error('email')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="countries" class="block mb-2 font-semibold text-blue-500">@lang('public.country')</label>
                    <div class="flex w-full">
                        <span id="flag" class="fi fi-us mx-4"></span>
                        <select id="countries" onchange= "onchangeDropdown()" name="country" class="js-example-basic-single bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('country') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror">
                            <option value="">
                                @lang('public.select_country')
                            </option>
                            @foreach ($countries as $country)
                                <option value="{{ $country }}" @selected(old('country') == $country)>
                                    @switch(app()->getLocale())
                                        @case('en')
                                            {{ $country->name }}
                                            @break

                                        @case('cn')
                                            {{ $country->name_cn }}
                                            @break

                                        @case('tw')
                                            {{ $country->name_tw }}
                                            @break

                                        @default
                                            <span class="fi fi-us mr-3 "></span>
                                            {{ $country->name }}
                                    @endswitch
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('country')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="phone" class="block mb-2 font-semibold text-blue-500">@lang('public.contact')</label>
                    <input type="tel" id="phone" name="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('phone') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" @if(old('phone')) value="{{ old('phone') }}" @endif placeholder="w. @lang('public.contact')">
                    @error('phone')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-6">
                <label for="code" class="block mb-2 font-semibold text-blue-500">@lang('public.referral_code')</label>
                @if($referral)
                    <input type="text" id="referral_code" value=" {{ $referral }}" name="referral" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('referral') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="">
                @else
                    <input type="text" id="referral_code" value=" {{ old('referral') }}" name="referral" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('referral') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="">
                @endif

                @error('referral')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="address" class="block mb-2 font-semibold text-blue-500">@lang('public.address')</label>
                <input type="text" id="address" @if(old('address')) value="{{ old('address') }}" @endif name="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('address') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.address')">
                @error('address')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="password" class="flex block mb-2 font-semibold text-blue-500">
                    @lang('public.password') <button data-popover-target="popover-description" data-popover-placement="bottom-start" type="button"><svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only"></span></button>
                    <div data-popover id="popover-description" role="tooltip" class="absolute z-10 invisible inline-block text-sm font-light text-gray-700 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                        <div class="p-3 space-y-2">
                            <h3 class="font-semibold text-gray-900 dark:text-white">@lang('public.password_type')</h3>
                            <p>@lang('public.password_validation_2')</p>
                            <p>@lang('public.password_validation_4')</p>
                        </div>
                        <div data-popper-arrow></div>
                    </div>
                </label>
                <div class="relative mb-2">
                    <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.password')">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-auto">
                        <button id='pass_button' type="button" class="text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm  ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" id="pass_svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                @error('password')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="confirm_password" class="block mb-2 font-semibold text-blue-500">@lang('public.password_confirmation')</label>
                <div class="relative mb-2">
                    <input type="password" id="confirm_password" name="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue- @error('password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.password_confirmation')">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-auto">
                        <button id='pass_confirm_button' type="button" class="text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm  ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" id="pass_confirm_svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
{{--            <div class="flex items-start mb-3">--}}
{{--                <div class="flex items-center h-5">--}}
{{--                    <input id="terms" type="checkbox" value="checked" name="tnc_check" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 checked:bg-blue-600 checked:border-blue-600 @error('tnc_check') w-4 h-4 border border-red-500 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 checked:bg-blue-600 checked:border-blue-600 @enderror">--}}
{{--                </div>--}}
{{--                <label for="terms" class="ml-2 text-sm font-medium text-gray-600 dark:text-gray-300 mb-4">@lang('public.tnc')</label>--}}
{{--                @error('tnc_check')--}}
{{--                <div class="text-sm text-red-600">{{ $message }}</div>--}}
{{--                @enderror--}}
{{--            </div>--}}
            <button type="submit" class="w-full px-6 py-2.5 bg-blue-500 text-white font-medium text-sm leading-tight rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">@lang('public.register_here')</button>
        </form>
        <p class="text-gray-600 text-sm mt-6 text-center">@lang('public.have_acc')
            <a href="{{url('/')}}" class="font-medium text-blue-500 hover:text-blue-700 focus:text-blue-700 transition duration-200 ease-in-out hover:underline">@lang('public.sign_in')</a>
        </p>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function onchangeDropdown(){
            var x = document.getElementById("countries").value;
            x = JSON.parse(x);
            document.getElementById("flag").classList = 'fi fi-' + x.code +' mx-4'
            document.getElementById("phone").value = x.phonecode
        }

        $(document).ready(function() {
            $('.js-example-basic-single').select2();

            $("#pass_button").click(function(){
                var password_id = document.getElementById("password");
                var password_icon = document.getElementById("pass_svg");
                if (password_id.type === "password") {
                    password_id.type = "text";
                    password_icon.innerHTML=`
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45
                        10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        `
                } else {
                    password_id.type = "password";
                    password_icon.innerHTML=`
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    `
                }
            });

            $("#pass_confirm_button").click(function(){
                var password_id = document.getElementById("confirm_password");
                var password_icon = document.getElementById("pass_confirm_svg");
                if (password_id.type === "password") {
                    password_id.type = "text";
                    password_icon.innerHTML=`
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45
                        10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        `
                } else {
                    password_id.type = "password";
                    password_icon.innerHTML=`
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    `
                }
            });
        })

    </script>
@endsection
