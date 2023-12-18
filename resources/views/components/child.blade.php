@php
    $count += 1
@endphp
@foreach ($children as $child)
    @if (count($child->children))
        <!-- With Child -->
        <div class="inline-flex mb-4 w-auto justify-center items-center" id="childContainer">
            <button
                class="inline-flex items-center justify-center w-8 h-8 bg-[#FFA168] hover:bg-orange-400 rounded-full shrink-0 grow-0 mr-4 dark:bg-gray-600 hide-child"
                type="button"
                id="{{ $child->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white transform rotate-180" id="svgPlus-child{{ $child->id }}">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <svg class="h-6 w-6 text-white" style="display: none" id="svgMinus-child{{ $child->id }}"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="5" y1="12" x2="19" y2="12" /></svg>
            </button>
            <a class="w-auto p-4 shadow-lg hover:shadow-2xl rounded-lg dark:bg-neutral-700 dark:text-neutral-50 inline-flex"
               href="{{ url("member/account/$child->id") }}" id="childBg-{{ $count }}">
                <div class="flex items-center space-x-4 sp">
                    <div class="inline-flex items-center justify-center w-8 h-8 bg-rose-400 rounded-full shrink-0 grow-0 dark:bg-gray-600" id="childColor-{{ $count }}">
                        <span class="font-bold text-md text-white">{{$count}}</span>
                    </div>
                    <div class="inline-flex items-center justify-center w-14 h-14 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600">
                        @if ($child->profile_image)
                            <img src="{{ asset('uploads/users/' .$child->profile_image)}}" id="profile_pic_preview" class="inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0  dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                        @else
                            <img src="{{url('/img/profile.png')}}" id="profile_pic_preview" class="inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0  dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                        @endif
                    </div>
                    <div class="font-semibold dark:text-white">
                        <div class=" text-md">{{$child->name}}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{$child->email}}</div>
                    </div>
                </div>
                <div class="flex items-center space-x-4 ml-12">
                    <div class="font-semibold dark:text-white">
                        <div class=" text-md">{{$child->rank->rank_short_form}}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">@lang('public.rank')</div>
                    </div>
                </div>
                <div class="flex items-center space-x-4 ml-12">
                    <div class="font-semibold dark:text-white">
                        <div class=" text-md">${{number_format($child->wallet_balance, 2)}}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">@lang('public.wallet_balance')</div>
                    </div>
                </div>
                <div class="flex items-center space-x-4 ml-12">
                    <div class="font-semibold dark:text-white">
                        <div class=" text-md">${{number_format($child->personalDeposits(), 2)}}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">@lang('public.total_personal_deposit')</div>
                    </div>
                </div>
                <div class="flex items-center space-x-4 ml-12">
                    <div class="font-semibold dark:text-white">
                        <div class=" text-md">${{number_format($child->groupTotalDeposit(), 2)}}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">@lang('public.total_group_deposit')</div>
                    </div>
                </div>
                <div class="flex items-center space-x-4 ml-12">
                    <div class="font-semibold dark:text-white">
                        <div class=" text-md">{{$child->getClientsCount()}}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">@lang('public.direct_downlines')</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="!visible hidden hideContent-{{ $child->id }} ml-6" id="collapseExample-{{$child->id}}" data-te-collapse-item>
            @include('components.child', ['children' => $child->children,])
        </div>
    @else
        <!-- Without Child -->
        <div class="inline-flex mb-4 w-auto justify-center items-center" id="childContainer">
            <a class="w-full p-4 shadow-lg hover:shadow-2xl rounded-lg dark:bg-neutral-700 dark:text-neutral-50 inline-flex"
               href="{{ url("member/account/$child->id") }}" id="childBg-{{ $count }}">
                <div class="flex items-center space-x-4 sp">
                    <div class="inline-flex items-center justify-center w-8 h-8 bg-rose-400 rounded-full shrink-0 grow-0 dark:bg-gray-600" id="childColor-{{ $count }}">
                        <span class="font-bold text-md text-white">{{$count}}</span>
                    </div>
                    <div class="inline-flex items-center justify-center w-14 h-14 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600">
                        @if ($child->profile_image)
                            <img src="{{ asset('uploads/users/' .$child->profile_image)}}" id="profile_pic_preview" class=" inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                        @else
                            <img src="{{url('/img/profile.png')}}" id="profile_pic_preview" class=" inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                        @endif
                    </div>
                    <div class="font-semibold dark:text-white">
                        <div class=" text-md">{{$child->name}}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{$child->email}}</div>
                    </div>
                </div>
                <div class="flex items-center space-x-4 ml-12">
                    <div class="font-semibold dark:text-white">
                        <div class=" text-md">{{$child->rank->rank_short_form}}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">@lang('public.rank')</div>
                    </div>
                </div>
                <div class="flex items-center space-x-4 ml-12">
                    <div class="font-semibold dark:text-white">
                        <div class=" text-md">${{number_format($child->wallet_balance, 2)}}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">@lang('public.wallet_balance')</div>
                    </div>
                </div>
                <div class="flex items-center space-x-4 ml-12">
                    <div class="font-semibold dark:text-white">
                        <div class=" text-md">${{number_format($child->personalDeposits(), 2)}}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">@lang('public.total_personal_deposit')</div>
                    </div>
                </div>
                <div class="flex items-center space-x-4 ml-12">
                    <div class="font-semibold dark:text-white">
                        <div class=" text-md">${{number_format($child->groupTotalDeposit(), 2)}}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">@lang('public.total_group_deposit')</div>
                    </div>
                </div>
                <div class="flex items-center space-x-4 ml-12">
                    <div class="font-semibold dark:text-white">
                        <div class=" text-md">{{$child->getClientsCount()}}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">@lang('public.direct_downlines')</div>
                    </div>
                </div>
            </a>
        </div>
    @endif
@endforeach
