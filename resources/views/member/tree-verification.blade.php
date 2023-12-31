@extends('layouts.master-member')

@section('title') Change Password @endsection

@section('contents')
    <div class="block p-6 shadow-lg bg-blue-100 max-w-lg mx-auto">
        <a href="{{ url('member/dashboard') }}">
            <img class ="h-20 mx-auto my-6" src="{{url('/img/WV-icon.png')}}">
        </a>
        <p class="font-semibold m-6 text-center text-lg text-gray-700">@lang('public.tree_verification')</p>
        <form method="post" action="{{ route('tree_verification', $type) }}">@csrf
            <div class="form-group mb-6">
                <label for="current_password" class="form-label inline-block mb-2 text-blue-500 font-semibold">@lang('public.enter_password')</label>
                <div class="relative mb-2">
                    <input type="password" id="current_password" name="current_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('current_password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.enter_password')">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-auto">
                        <button id='current_pass_button' type="button" class="text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm  ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" id="pass_current_svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                @error('current_password')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="
            w-full
            px-6
            py-2.5
            bg-blue-500
            text-white
            font-medium
            text-sm
            leading-tight
            rounded
            shadow-md
            hover:bg-blue-700 hover:shadow-lg
            focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
            active:bg-blue-800 active:shadow-lg
            transition
            duration-150
            ease-in-out">@lang('public.verify')</button>
            <p class="text-gray-800 mt-6 text-center">
                <a href="{{ url('member/dashboard')}}" class="text-blue-500 hover:text-blue-700 focus:text-blue-700 transition duration-200 ease-in-out hover:underline">@lang('public.back')</a>
            </p>
        </form>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $("#current_pass_button").click(function(){
                var password_id = document.getElementById("current_password");
                var password_icon = document.getElementById("pass_current_svg");
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
