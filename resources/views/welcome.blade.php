@extends('layouts.master-without-nav')

@section('title') Login @endsection

@section('contents')
    <div class="w-full bg-[#FDFCF3] rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
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
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8 bg-[#FDFCF3] rounded-lg">
            <a href="#" class="flex justify-center my-4 items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="h-20 mr-2" src="{{asset('img/CW.png')}}" alt="logo">
            </a>
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                @lang('public.welcome_back').
            </h1>
            <form class="space-y-4 md:space-y-6" method="post" action="{{ url('login') }}">
                @csrf
                <div>
                    <label for="email" class="block mb-2 font-semibold text-orange-400">@lang('public.email_address')</label>
                    <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('email') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" @if(old('email')) value="{{ old('email') }}" @endif placeholder="name@company.com">
                    @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block mb-2 font-semibold text-orange-400">@lang('public.password')</label>
                    <div class="relative mb-2">
                        <input type="password" name="password" id="password" placeholder="@lang('public.password')" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full  p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" id="password" @if(old('password')) value="{{ old('password') }}" @endif >
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
                    <div>
                        <p class="text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="remember" aria-describedby="remember" name="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-orange-400 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="remember" class="text-gray-500 dark:text-gray-300">@lang('public.remember_me')</label>
                        </div>
                    </div>
                    <a href="{{url('/forgot-password')}}" class="text-sm font-medium text-orange-500 hover:text-orange-700 focus:text-orange-700 transition duration-200 ease-in-out hover:underline">@lang('public.forgot_password')?</a>
                </div>
                <button type="submit" class="w-full px-6 py-2.5 bg-orange-400 text-white font-medium text-sm leading-tight rounded shadow-md hover:bg-orange-700 hover:shadow-lg focus:bg-orange-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-orange-800 active:shadow-lg transition duration-150 ease-in-out">@lang('public.sign_in')</button>
                <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                    @lang('public.dont_have_acc')? <a href="{{url('/register')}}" class="font-medium text-orange-500 hover:text-orange-700 focus:text-orange-700 transition duration-200 ease-in-out hover:underline">@lang('public.register_here')</a>
                </p>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
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
        })
    </script>
@endsection
