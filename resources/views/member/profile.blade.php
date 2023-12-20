@extends('layouts.master-member')

@section('title') Profile @endsection

@section('contents')
    <nav class="flex " aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 text-lg font-semibold">
            <li class="inline-flex items-center">
                <p href="#" class="inline-flex items-center text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 mr-4">
                        <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
                    </svg>
                    @lang('public.profile')
                </p>
            </li>
            <li>
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <p href="#" class="ml-1  text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">@lang('public.profile_details')</p>
                </div>
            </li>
        </ol>
    </nav>
        <div class="grid grid-flow-row grid-flow-cols grid-cols-3 gap-3 my-4 max-[1200px]:grid-rows-auto max-[1200px]:grid-cols-none ">
            <div class="flex justify-center max-[1200px]:justify-start ">
                <div class="block rounded-lg bg-blue-100 border-2 text-center shadow-lg dark:bg-neutral-700 w-full">
                    <div class="pt-6 pb-4 px-6 dark:text-neutral-50 flex text-blue-500 font-bold text-lg">
                        @lang('public.rank')
                    </div>
                    <div class="py-1">
                        <div class="relative inline-flex items-center justify-center w-28 h-28 overflow-hidden bg-blue-500 rounded-full dark:bg-gray-600">
                            <span class="font-bold text-white dark:text-gray-300 text-lg">{{$rank->rank_short_form}}</span>
                        </div>
                        <h5 class="my-6 text-lg font-bold leading-tight text-[#696057] dark:text-neutral-50">
                            @lang('public.'. $rank->rank_short_form )
                        </h5>
                    </div>
                </div>
            </div>
            <div class="flex justify-center col-span-2 max-[1200px]:col-span-1 max-[1200px]:justify-start ">
                <div class="block rounded-lg bg-blue-100 border-2 shadow-lg dark:bg-neutral-700 w-full py-4">
                    <div class="pt-4 px-6 flex items-center text-blue-500 font-bold text-lg">
                        @lang('public.personal_details')
                        @if($user->user_profiles)
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium mx-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">@lang('public.process')</span>
                        @endif
                    </div>
                    <div class="grid grid-cols-2 max-[1200px]:grid-cols-none">
                        <div class="px-12 py-4">
                            <p class="font-medium text-gray-500 dark:text-gray-400 "> @lang('public.name'):</p>
                            <h5 class="mb-2 text-lg font-semibold tracking-tight text-[#696057] dark:text-white">{{$user->name}}</h5>
                        </div>
                        <div class="px-12 py-4">
                            <p class="font-medium text-gray-500 dark:text-gray-400 "> @lang('public.email'):</p>
                            <h5 class="mb-2 text-lg font-semibold tracking-tight text-[#696057] dark:text-white">{{$user->email}}</h5>
                        </div>
                        <div class="px-12 py-4">
                            <p class="font-medium text-gray-500 dark:text-gray-400 "> @lang('public.country'):</p>
                            <div class="flex items-center space-x-4">
                                @if($user->countryFlag)
                                    <span class="fi fi-{{$user->countryFlag}} "></span>
                                @endif
                                <h5 class=" text-lg font-semibold tracking-tight text-[#696057] dark:text-white">{{ $user->getTranslatedCountry() }}</h5>
                            </div>
                        </div>
                        <div class="px-12 py-4">
                            <p class="font-medium text-gray-500 dark:text-gray-400 "> @lang('public.contact'):</p>
                            <div class="flex items-center space-x-4">
                                <h5 class=" text-lg font-semibold tracking-tight text-[#696057] dark:text-white">{{$user->contact_number}}</h5>
                            </div>
                        </div>
                        <div class="px-12 py-4">
                            <p class="font-medium text-gray-500 dark:text-gray-400 "> @lang('public.address'):</p>
                            <h5 class="mb-2 text-lg font-semibold tracking-tight text-[#696057] dark:text-white">
                                {{$user->address}}
                            </h5>
                        </div>
                    </div>
                    <div class="pr-6 flex justify-end">
                        <button data-modal-target="editProfileModal" data-modal-toggle="editProfileModal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                            @lang('public.member_edit')
                        </button>
                    </div>

                </div>
            </div>
            <div class="flex justify-center max-[1200px]:justify-start mt-3 ">
                <div class="block  rounded-lg bg-blue-100 border-2 text-center shadow-lg dark:bg-neutral-700 w-full py-4">
                    <div class="py-4 px-6 dark:text-neutral-50 flex text-blue-500 font-bold text-lg">
                        @lang('public.avatar')
                    </div>
                    <div class="">
                        @if ($user->profile_image)
                            <img src="{{ asset('uploads/users/' .$user->profile_image)}}" class="relative inline-flex items-center justify-center w-28 h-28 overflow-hidden bg-blue-500 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                        @else
                            <img src="{{url('/img/profile.png')}}" class="relative inline-flex items-center justify-center w-28 h-28 overflow-hidden bg-blue-500 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                        @endif
                    </div>
                    <button data-modal-target="avatarModal" data-modal-toggle="avatarModal" type="button" class="font-semibold my-6 text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5  dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        @lang('public.change_avatar')
                    </button>
                </div>
            </div>
            <div class="flex justify-center col-span-2 max-[1200px]:col-span-1 max-[1200px]:justify-start mt-3 ">
                <div class="block rounded-lg bg-blue-100 border-2 shadow-lg dark:bg-neutral-700 w-full py-4">
                    <div class="pt-4 px-6 flex text-blue-500 font-bold text-lg">
                        @lang('public.wallet_setting')
                    </div>
                    <div class="grid grid-cols-2 max-[1200px]:grid-cols-none">
                        <div class="px-12 py-4">
                            <p class="font-medium text-gray-500 dark:text-gray-400 mb-4">@lang('public.wallet_address'):</p>
                            @if($user->user_wallet)
                                <div class="flex flex-col my-2">
                                    <span class="font-semibold text-lg text-[#696057] dark:text-white">
                                      @lang('public.type') - <span class="uppercase">{{ $user->user_wallet->wallet_type }}</span>
                                        @if($user->user_wallet->wallet_address_request_status == \App\Models\UserWallet::STATUS_PENDING)
                                            <span class="inline-block ml-2 px-2 py-1 text-sm font-semibold text-white bg-blue-500 rounded">@lang('public.pending')</span>
                                        @endif
                                    </span>
                                    <span class="font-semibold text-lg text-[#696057] dark:text-white">@lang('public.address') - {{ substr_replace($user->user_wallet->wallet_address, '******', 3, -3) }}</span>
                                </div>
                                @if(!$user_withdrawal_status)
                                    <button data-modal-target="wallet-address-modal" data-modal-toggle="wallet-address-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <svg class="h-5 w-5 text-white mr-2 -ml-1"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        @lang('public.edit')
                                    </button>
                                @endif
                            @else
                                <button data-modal-target="wallet-address-modal" data-modal-toggle="wallet-address-modal" type="button" class="text-white bg-success hover:bg-success-800 focus:ring-4 focus:outline-none focus:ring-success-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-success-600 dark:hover:bg-success-700 dark:focus:ring-success-800">
                                    <svg class="h-5 w-5 text-white mr-2 -ml-1"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />  <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" /></svg>
                                    @lang('public.create_wallet')
                                </button>
                            @endif
                        </div>
                        <div class="px-12 py-4">
                            <p class="font-medium text-gray-500 dark:text-gray-400 mb-4"> @lang('public.withdrawal_pin'):</p>
                            <div class="flex items-center space-x-4">
                                @if($user->withdrawal_pin)
                                    <button data-modal-target="withdrawal-pin-modal" data-modal-toggle="withdrawal-pin-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <svg class="h-5 w-5 text-white mr-2 -ml-1"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />  <path d="M7 11V7a5 5 0 0 1 9.9-1" /></svg>
                                        @lang('public.edit')
                                    </button>
                                @else
                                    <button data-modal-target="withdrawal-pin-modal" data-modal-toggle="withdrawal-pin-modal" type="button" class="text-white bg-success hover:bg-success-800 focus:ring-4 focus:outline-none focus:ring-success-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-success-600 dark:hover:bg-success-700 dark:focus:ring-success-800">
                                        <svg class="h-5 w-5 text-white mr-2 -ml-1"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />  <path d="M7 11V7a5 5 0 0 1 9.9-1" /></svg>
                                        @lang('public.setup_pin')
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>
      <div id="avatarModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-2xl md:h-auto">
            <form method="post" action="{{ url('member/update-profile-pic') }}" enctype="multipart/form-data">@csrf
            <!-- Modal content -->
            <div class="relative bg-blue-100 rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-blue-500 dark:text-white">
                        @lang('public.upload_avatar')
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="avatarModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only"> @lang('public.close_modal')</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-2 ">

                    <img class="mx-auto w-32 h-32 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500 bg-gray-100" id="profile_pic_preview"
                    @if ($user->profile_image)
                        src="{{ asset('uploads/users/' .$user->profile_image)}}"
                    @else
                       src="{{url('/img/profile.png')}}"
                    @endif
                         alt="avatar">

                    <label class="block my-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">@lang('public.upload_file')</label>
                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                           aria-describedby="file_input_help" id="file_input" name="profile_image" type="file"
                           accept="image/png, image/gif, image/jpeg" >
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">@lang('public.profile_pic_req')</p>
                    @error('profile_image')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button  type="submit" name="submit" data-modal-hide="avatarModal" type="button" class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">@lang('public.save')</button>
                    <button data-modal-hide="avatarModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">@lang('public.cancel')</button>
                </div>

            </div>
            </form>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editProfileModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-blue-500 dark:text-white">Edit Profile</h3>
                    <form class="space-y-6" action="{{ route('edit_profile') }}" method="POST" id="editProfile">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('public.name')</label>
                                <input type="text" name="name" id="name" value="{{ $user->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                <span class="text-danger text-xs error-text name_error"></span>
                            </div>
                            <div class="space-y-2">
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('public.email')</label>
                                <input type="email" name="email" id="email" value="{{ $user->email }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" disabled>
                            </div>
                            <div class="space-y-2">
                                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('public.country')</label>
                                <div class="flex w-full">
                                    <span id="flag" class="fi fi-us mx-4"></span>
                                    <select id="countries" name="country" class="js-example-basic-single bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">@lang('public.select_country')</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ json_encode($country) }}" @if ($user->country == $country->name) selected @endif>
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
                                <span class="text-danger text-xs error-text country_error"></span>

                            </div>
                            <div class="space-y-2">
                                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('public.contact')</label>
                                <input type="text" name="contact_number" id="phone" value="{{ $user->contact_number }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                <span class="text-danger text-xs error-text contact_number_error"></span>
                            </div>
                            <div class="space-y-2 md:col-span-2">
                                <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('public.address')</label>
                                <input type="text" name="address" id="address" value="{{ $user->address }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                <span class="text-danger text-xs error-text address_error"></span>
                            </div>
                        </div>
                        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Wallet Address Modal -->
    <div id="wallet-address-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="wallet-address-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-bold text-blue-500 dark:text-white">@lang('public.wallet_address')</h3>
                    <form class="space-y-6" action="{{ route('wallet_address') }}" method="POST" id="wallet_address">
                        @csrf
                        <div>
                            <label for="wallet_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('public.wallet_type') (USDT)</label>
                            <input type="text" name="wallet_type" id="wallet_type" class="bg-gray-50 uppercase border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Wallet Type" readonly value="trc20">
                            <span class="text-danger text-xs error-text wallet_type_error"></span>
                        </div>
                        <div>
                            <label for="wallet_address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('public.wallet_address')</label>
                            <input type="text" name="wallet_address" id="wallet_address" placeholder="{{ trans('public.wallet_address') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="{{ @$user->user_wallet->wallet_address }}">
                            <span class="text-danger text-xs error-text wallet_address_error"></span>
                        </div>
                        @if(!empty($user->wallet_address_request))
                            <button type="submit" class="w-full text-white bg-[#2AC769] hover:bg-success-800 focus:ring-4 focus:outline-none focus:ring-success-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">@lang('public.save')</button>
                        @else
                            <button type="submit" class="w-full text-white bg-[#2AC769] hover:bg-success-800 focus:ring-4 focus:outline-none focus:ring-success-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">@lang('public.submit_request')</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Withdrawal Pin Modal -->
    <div id="withdrawal-pin-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="withdrawal-pin-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-bold text-blue-500 dark:text-white">@lang('public.withdrawal_pin')</h3>
                    <form class="space-y-6" action="{{ route('withdrawal_pin') }}" method="POST" id="withdrawal_pin">
                        @csrf

                        @if(!empty($user->withdrawal_pin))
                            <div>
                                <label for="current_withdrawal_pin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('public.current_withdrawal_pin')</label>
                                <input type="password" name="current_withdrawal_pin" id="current_withdrawal_pin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="{{ trans('public.current_withdrawal_pin') }}">
                                <span class="text-danger text-xs error-text current_withdrawal_pin_error"></span>
                            </div>
                        @endif
                        <div>
                            <label for="new_withdrawal_pin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('public.new_withdrawal_pin')</label>
                            <input type="password" name="withdrawal_pin" id="new_withdrawal_pin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="{{ trans('public.new_withdrawal_pin') }}">
                            <span class="text-danger text-xs error-text withdrawal_pin_error"></span>
                        </div>
                        <div>
                            <label for="withdrawal_pin_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('public.withdrawal_pin_confirmation')</label>
                            <input type="password" name="withdrawal_pin_confirmation" id="withdrawal_pin_confirmation" placeholder="{{ trans('public.withdrawal_pin_confirmation') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                        </div>
                        <button type="submit" class="w-full text-white bg-[#2AC769] hover:bg-success-800 focus:ring-4 focus:outline-none focus:ring-success-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">@lang('public.save')</button>
                    </form>
                    <div class="flex justify-center mt-2 text-blue-500 hover:cursor-pointer hover:text-blue-700">
                        <form action="{{ route('send_withdrawal_reset_link') }}" method="POST" id="sendResetLink">
                            @csrf
                            <button type="submit" class="text-blue-500 text-sm">@lang('public.click_to_get_reset_link')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function(){
            var selectedCountry = JSON.parse($("#countries").val());

            $("#flag").removeClass().addClass("fi fi-" + selectedCountry.code + " mx-4");

            $("#countries").change(function() {
                var selectedCountry = JSON.parse($(this).val());

                $("#flag").removeClass().addClass("fi fi-" + selectedCountry.code + " mx-4");
                $("#phone").val(selectedCountry.phonecode);
            });

            $('#editProfile').on('submit', function(e) {
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
                                icon: 'warning',
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
                            text: 'An error occurred while processing your request. Contact Admin.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            timer: 4000,
                            timerProgressBar: false,
                        });
                    }
                });
            });

            $('#wallet_address').on('submit', function(e) {
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
                                icon: 'warning',
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
                            text: 'An error occurred while processing your request. Contact Admin.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            timer: 4000,
                            timerProgressBar: false,
                        });
                    }
                });
            });

            $('#withdrawal_pin').on('submit', function(e) {
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
                                icon: 'warning',
                                confirmButtonText: 'OK',
                                timer: 3000,
                                timerProgressBar: false,
                            }).then(function() {
                                location.reload();
                            });
                        } else if (data.status == 3) {
                            Swal.fire({
                                title: '{{ trans('public.invalid_action') }}',
                                text: data.msg,
                                icon: 'warning',
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
                            text: 'An error occurred while processing your request. Contact Admin.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            timer: 4000,
                            timerProgressBar: false,
                        });
                    }
                });
            });

            $('#sendResetLink').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var submitButton = form.find('button[type="submit"]');
                $.ajax({
                    method:$(this).attr('method'),
                    url:$(this).attr('action'),
                    data:new FormData(this),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend: function() {
                        form.find('span.error-text').text('');
                        // Disable the submit button and change the text to "Processing"
                        submitButton.prop('disabled', true).text('Processing...');
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
                                icon: 'warning',
                                confirmButtonText: 'OK',
                                timer: 3000,
                                timerProgressBar: false,
                            }).then(function() {
                                location.reload();
                            });
                        } else if (data.status == 3) {
                            Swal.fire({
                                title: '{{ trans('public.invalid_action') }}',
                                text: data.msg,
                                icon: 'warning',
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
                            text: 'An error occurred while processing your request. Contact Admin.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            timer: 4000,
                            timerProgressBar: false,
                        });
                    },
                    complete: function() {
                        // Re-enable the submit button and change the text back to its original value
                        submitButton.prop('disabled', false).text('Submit');
                    }
                });
            });
        });
    </script>
@endsection
