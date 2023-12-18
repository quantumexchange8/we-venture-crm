@extends('layouts.master-admin')

@section('title') Member Details @endsection

@section('contents')

    <div class="flex flex-row gap-4 max-[1150px]:block">
        <h1 class="flex-1 font-semibold text-2xl text-gray-600">@lang('public.members') / {{ $user->name }}</h1>
        <a href="javascript:void(0)" id="{{ $user->id }}" data-modal-target="extra_bonus" data-modal-toggle="extra_bonus" class="adjust_amount_button mt-2 bg-[#fd7f6f] hover:bg-rose-400 border border-rose-400 focus:ring-4 focus:outline-none focus:ring-rose-400 rounded-lg px-5 py-2.5 text-center inline-flex items-center " >

            <svg class="h-4 w-4 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" />  <path d="M12 3v3m0 12v3" /></svg>

            <span class="ml-4 text-white">@lang('public.extra_bonus')</span>
        </a>
        <a href="javascript:void(0)" id="{{ $user->id }}" data-modal-target="adjustment-modal" data-modal-toggle="adjustment-modal" class="adjust_amount_button mt-2 bg-warning hover:bg-warning-600 border border-warning-200 focus:ring-4 focus:outline-none focus:ring-warning-400 rounded-lg px-5 py-2.5 text-center inline-flex items-center " >

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3" />
            </svg>

            <span class="ml-4 text-white">@lang('public.wallet_adjustment')</span>
        </a>
        <a href="{{ route('member_deposit', $user->id) }}" class="mt-2 bg-gray-600 hover:bg-gray-400 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-600 rounded-lg px-5 py-2.5 text-center inline-flex items-center ">
            <svg class="h-4 w-4 text-white"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            <span class="ml-4 text-white">@lang('public.view_deposit')</span>
        </a>
        <a href="{{ route('member_edit', $user->id) }}" class="mt-2 bg-[#4DA5FF]  hover:bg-blue-600 border border-blue-200 focus:ring-4 focus:outline-none focus:ring-blue-600 font-semibold text-md text-gray-500 rounded-lg px-5 py-2.5 text-center inline-flex items-center ">
            <svg class="h-4 w-4 text-white" width="24"  height="24"  viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" /></svg>
            <span class="ml-4 text-white">@lang('public.edit')</span>
        </a>

    </div>
    <div class="flex justify-center mt-8">
        <div class="grid grid-cols-4 items-start rounded-xl bg-[#FDFCF3] p-4 shadow-lg w-full max-[1150px]:grid-cols-3">

            <div class="col-span-1 flex-col items-center py-8 border-r-4 border-orange-500 h-full px-12 text-center max-[1150px]:col-span-3 max-[1150px]:border-none">
                <div class="relative inline-flex items-center justify-center w-20 h-20 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600">
                    @if ($user->profile_image)
                        <img src="{{ asset('uploads/users/' .$user->profile_image)}}" id="profile_pic_preview" class="relative inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                    @else
                        <img src="{{url('/img/profile.png')}}" id="profile_pic_preview" class="relative inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                    @endif

                </div>
                <h5 class="font-bold text-lg text-gray-600 text-center mt-4 mb-2">{{ $user->name }}</h5>
                <span class="font-semibold text-lg text-orange-400 text-center">{{ $user->rank->rank_short_form }}</span>
                <div class="items-center mt-4 md:mt-6">
                    <p class="font-semibold text-md text-orange-400 mt-4">@lang('public.last_rank_up'):</p>
                    <div class="font-semibold text-sm text-gray-600">
                        <p class="mb-2">
                            {{\Carbon\Carbon::parse($user->rank_update_at)->format('Y-m-d')}}
                        </p>
                        <span class="bg-gray-300 text-gray-800 text-sm font-medium shadow-lg px-2.5 py-1.5 rounded dark:bg-gray-700 dark:text-gray-300">
                            {{$user->auto_rank_up ? trans('public.auto') : trans('public.manual')}}
                        </span>
                    </div>
                </div>
                <div class="flex mt-4 space-x-3 md:mt-6">
                    <button
                        data-modal-target="ranking_details_modal" data-modal-toggle="ranking_details_modal"
                        class="mx-auto inline-flex items-center px-8 py-2 text-center text-white bg-[#FFA168] rounded-lg hover:bg-orange-400 focus:ring-4 focus:outline-none focus:ring-orange-300"
                        data-te-ripple-init
                        data-te-ripple-color="light">
                        @lang('public.rank_details')
                    </button>
                </div>
            </div>

            <div class="col-span-3 ml-4 p-4 md:mt-6">
                <div class="grid grid-cols-2 gap-4 break-words max-[800px]:grid-cols-1">
                    <div class="px-4">
                        <h2 class="font-semibold text-md text-orange-400 mb-4">@lang('public.email')</h2>
                        <span class="font-semibold text-md text-gray-500">
                            {{ $user->email }}
                        </span>
                    </div>
                    <div class="px-4">
                        <h2 class="font-semibold text-md text-orange-400 mb-4">@lang('public.contact')</h2>
                        <span class="font-semibold text-md text-gray-500">
                            {{ $user->contact_number }}
                        </span>
                    </div>
                    <div class="mt-6 px-4">
                        <h2 class="font-semibold text-md text-orange-400 mb-4">@lang('public.address')</h2>
                        <span class="font-semibold text-md text-gray-500">
                            {{ $user->address }}
                        </span>
                    </div>
                    <div class="mt-6 px-4">
                        <h2 class="font-semibold text-md text-orange-400 mb-4">@lang('public.country')</h2>
                        <span class="font-semibold text-md text-gray-500">
                            @switch(app()->getLocale())
                                @case('en')
                                    <h5 class=" text-md font-semibold text-gray-500 dark:text-white">{{ $country_trans }}</h5>
                                    @break

                                @case('cn')
                                    <h5 class=" text-md font-semibold text-gray-500 dark:text-white">{{ $country_trans }}</h5>
                                    @break

                                @case('tw')
                                    <h5 class=" text-md font-semibold text-gray-500 dark:text-white">{{ $country_trans }}</h5>
                                    @break

                                @default
                                    <h5 class=" text-md font-semibold text-gray-500 dark:text-white">{{ $country_trans }}</h5>
                            @endswitch
                        </span>
                    </div>
                    <div class="mt-6 px-4">
                        <h2 class="font-semibold text-md text-orange-400 mb-4">@lang('public.date_join')</h2>
                        <span class="font-semibold text-md text-gray-500">
                            {{ $user->created_at }}
                        </span>
                    </div>
                    <div class="mt-6 px-4">
                        <h2 class="font-semibold text-md text-orange-400 mb-4">@lang('public.status')</h2>
                        @if($user->status == 1)
                            <span class="text-success font-semibold text-md text-gray-500">@lang('public.active')</span>
                        @elseif($user->status == 2)
                            <span class="text-warning font-semibold text-md text-gray-500">@lang('public.inactive')</span>
                        @elseif($user->status == 3)
                            <span class="text-danger font-semibold text-md text-gray-500">@lang('public.suspend')</span>
                        @endif
                    </div>
                    <div class="mt-6 px-4">
                        <h2 class="font-semibold text-md text-orange-400 mb-4">@lang('public.leader_status')</h2>
                        <span class="font-semibold text-md text-gray-500">
                            {{ $user->leader_status ? trans('public.yes') : trans('public.no') }}
                        </span>
                    </div>
                    <div class="mt-6 px-4">
                        <form action="{{ route('member_kyc_approval') }}" method="post">
                            @csrf
                            <h2 class="font-semibold text-md text-orange-400 mb-2">@lang('public.kyc_approval_status')</h2>
                            <span class="font-semibold text-md text-gray-500">
                                @if($user->kyc_approval_status == 3)
                                    <span class="text-success font-semibold mr-2 mb-2 uppercase">@lang('public.kyc_verified')</span>
                                @elseif($user->kyc_approval_status == 2)
                                    <span class="text-warning font-semibold mr-2 mb-2 uppercase">@lang('public.kyc_pending_verify')</span>
                                @elseif($user->kyc_approval_status == 4)
                                    <span class="text-danger font-semibold mr-2 mb-2 uppercase">@lang('public.reject')</span>
                                @elseif($user->kyc_approval_status == 1)
                                    <span class="text-danger font-semibold mr-2 mb-2 uppercase">@lang('public.kyc_not_verify')</span>
                                @endif
                            </span>
                            @if($user->kyc_approval_status != App\Models\User::KYC_STATUS_VERIFIED)
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <input type="hidden" name="direct_approve" value="direct_approve">
                                <button type="submit" name="approval" value="{{App\Models\User::KYC_STATUS_VERIFIED}}" class="text-white bg-success hover:bg-success-500 focus:ring-4 focus:outline-none focus:ring-success-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-success-600 dark:hover:bg-success-700 dark:focus:ring-success-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 -ml-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    @lang('public.approve')
                                </button>
                            @endif
                        </form>
                    </div>
                    <div class="mt-6 px-4">
                        <h2 class="font-semibold text-md text-orange-400 mb-4">@lang('public.email_status')</h2>
                        <span class="font-semibold text-md text-gray-500">
                            {{ $user->email_status == 1 ? trans('public.yes') : trans('public.no') }}
                        </span>
                    </div>
                    <div class="mt-6 px-4">
                        <h2 class="font-semibold text-md text-orange-400 mb-4">@lang('public.wallet_status')</h2>
                        @if($user->user_wallet && $user->user_wallet->wallet_status == \App\Models\UserWallet::STATUS_ACTIVE)
                            <span class="text-success font-semibold text-md text-gray-500">@lang('public.active')</span>
                        @else
                            <span class="text-warning font-semibold text-md text-gray-500">@lang('public.inactive')</span>
                        @endif
                    </div>
                    @if($user->extra_bonus)
                        <div class="mt-6 px-4">
                            <h2 class="font-semibold text-md text-orange-400 mb-4">@lang('public.extra_bonus')</h2>
                            <span class="font-semibold text-md text-gray-500">
                                $ {{ $user->extra_bonus->bonus_amount }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Ranking Details Modal -->
    <div id="ranking_details_modal" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-2xl md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-md p-4 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-hide="ranking_details_modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 space-y-6">
                    <form method="post" action="{{ route('member_details', $user->id) }}">
                        @csrf
                        <div class="mb-2 text-center text-sm font-bold">
                            @lang('public.rank_details')
                        </div>
                        <div class="mb-6 text-center text-2xl font-bold">
                            {{ $user->name }}
                        </div>
                        <div class="mb-6">
                            <label for="rank" class="block mb-2 text-lg text-[#FFA168]">@lang('public.change_rank')</label>
                            {!! Form::select('rankId', $get_rank_sel, $post->rankId, ['class' => 'bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500', 'id' => 'rank_sel']) !!}
                        </div>
                        <div class="mb-6">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="auto_rank_up" id="autoRankSwitch" value="on" class="sr-only peer" @if( @$post->auto_rank_up == 1 ) checked @endif>
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-gray-200 dark:peer-focus:ring-orange-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-[#FFA168]"></div>
                                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">@lang('public.auto_rank_up')</span>
                            </label>
                        </div>
                        <div class="mb-6">
                            <label for="lowest_rank" class="block mb-2 text-lg text-[#FFA168]">@lang('public.lowest_rank')</label>
                            {!! Form::select('lowest_rank', $get_rank_sel, $post->lowest_rank, ['class' => 'bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500', 'id' => 'lowest_rank']) !!}
                        </div>
                        <div class="text-center">
                            <button type="submit" class="text-white bg-[#FFA168] hover:bg-orange-400 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm w-full sm:w-auto px-10 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800 inline-flex items-center justify-center">@lang('public.confirm')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="adjustment-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="adjustment-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">@lang('public.wallet_adjustment')</h3>
                    <form class="space-y-6" method="POST" action="{{ route('wallet_adjustment') }}">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="user_id" id="user_id">
                        </div>
                        <div>
                            <label for="old_balance" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('public.wallet_balance')</label>
                            <input type="text" name="old_balance" id="old_balance" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="{{ number_format($user->wallet_balance, 2) }}" disabled>
                        </div>
                        <div>
                            <label for="adjust_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('public.adjustment_amount')</label>
                            <input type="number" min="0" step='0.01' name="adjust_amount" id="adjust_amount" placeholder="0.00" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                        </div>
                        <div>
                            <label for="adjust_remark" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('public.adjustment_remark')</label>
                            <textarea  name="adjust_remark" id="adjust_remark" placeholder="Leave your remark here!" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"></textarea>
                        </div>
                        <button type="submit" class="w-full text-white bg-orange-400 hover:bg-orange-400 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">@lang('public.submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Extra Bonus Modal -->
    <div id="extra_bonus" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="extra_bonus">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">@lang('public.extra_bonus')</h3>
                    <form class="space-y-6" method="POST" action="{{ route('member_extra_bonus') }}" id="extra_bonus_form">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                        </div>
                        <div>
                            <label for="old_balance" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('public.user')</label>
                            <input type="text" name="old_balance" id="old_balance" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="{{ $user->name }}" disabled>
                        </div>
                        <div>
                            <label for="bonus_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">@lang('public.amount')</label>
                            <input type="number" min="0" step='0.01' name="bonus_amount" id="bonus_amount" placeholder="0.00" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                            <span class="text-danger text-xs error-text bonus_amount_error"></span>
                        </div>
                        <button type="submit" class="w-full text-white bg-orange-400 hover:bg-orange-400 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">@lang('public.submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function(e) {
            $("#rank_sel").click(function() {
                var checkBoxes = $("#autoRankSwitch");
                checkBoxes.prop("checked", false);
            });

            $('.adjust_amount_button').on('click', function() {
                var id = $(this).attr('id');
                $(".modal-body #user_id").val( id );
            });

            $('#extra_bonus_form').on('submit', function(e) {
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
                                $('#'+prefix).addClass('border-danger');
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
