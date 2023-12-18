@extends('layouts.master-member')

@section('title') Network Tree @endsection

@section('contents')
    <nav class="flex max-[1000px]:flex-col" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xl font-semibold mb-4">
            <li class="inline-flex items-center">
                <p href="#" class="inline-flex items-center text-gray-700 hover:text-orange-600 dark:text-gray-400 dark:hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 mr-4">
                        <path fill-rule="evenodd"
                              d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z"
                              clip-rule="evenodd"/>
                        <path
                            d="M5.082 14.254a8.287 8.287 0 00-1.308 5.135 9.687 9.687 0 01-1.764-.44l-.115-.04a.563.563 0 01-.373-.487l-.01-.121a3.75 3.75 0 013.57-4.047zM20.226 19.389a8.287 8.287 0 00-1.308-5.135 3.75 3.75 0 013.57 4.047l-.01.121a.563.563 0 01-.373.486l-.115.04c-.567.2-1.156.349-1.764.441z"/>
                    </svg>
                    @lang('public.network_plan')
                </p>
            </li>
            <li>
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <div href="#" class="ml-1  text-gray-700 hover:text-orange-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">@lang('public.network_tree')</div>
                </div>
            </li>
        </ol>
    </nav>
    <div class="text-sm font-medium text-gray-500 mb-6">
        @lang('public.last_updated') {{ today() }}
    </div>
        <div class=" w-auto ">
            <div class="px-4">
                <form action="{{ url('member/tree') }}" method="post" class="flex max-[900px]:flex-col gap-3 mb-4">
                    @csrf
                    <div class="relative w-4/12 max-[900px]:w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="text" id="search" name="freetext" value="{{ @$search['freetext'] }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="@lang('public.search_email')">
                    </div>
                    <button data-tooltip-target="tooltip-search" type="submit" name="submit" value="search" class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                    <div id="tooltip-search" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        @lang('public.search')
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <button data-tooltip-target="tooltip-reset" type="submit" name="submit" value="reset" class="flex items-center justify-center text-white bg-rose-500 hover:bg-rose-600 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-3 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="h-4 w-4 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -5v5h5" />  <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 5v-5h-5" /></svg>
                    </button>
                    <div id="tooltip-reset" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        @lang('public.reset')
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <button type="submit" name="submit" value="export" class="max-[900px]:justify-center text-white bg-secondary-800 hover:bg-secondary-500 focus:ring-4 focus:outline-none focus:ring-secondary-300 font-semibold rounded-lg text-md px-5 py-2.5 text-center inline-flex items-center dark:bg-secondary-600 dark:hover:bg-secondary-700 dark:focus:ring-secondary-800">
                        <svg class="h-6 w-6 mr-2" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 15V6C8 4.89543 8.89543 4 10 4H38C39.1046 4 40 4.89543 40 6V42C40 43.1046 39.1046 44 38 44H10C8.89543 44 8 43.1046 8 42V33" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M31 15H34" stroke="#ffffff" stroke-width="3" stroke-linecap="round"/><path d="M28 23H34" stroke="#ffffff" stroke-width="3" stroke-linecap="round"/><path d="M28 31H34" stroke="#ffffff" stroke-width="3" stroke-linecap="round"/><rect x="4" y="15" width="18" height="18" fill="none" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 21L16 27" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 21L10 27" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @lang('public.export_excel')
                    </button>
                </form>

                <div class="relative overflow-x-auto lg:max-w-[972px] xl:max-w-[1100px] 2xl:max-w-[1200px]" id="parentContainer">
                    @if(count($members) > 0)
                        @foreach ($members as $member)
                            @php
                                $count = 1
                            @endphp
                            @if (count($member->children))
                                <!-- Parent with children -->
                                <div class="inline-flex mb-4 w-auto justify-center items-center toggle-{{$member->id}}">
                                    <button
                                        class="inline-flex items-center justify-center w-8 h-8 bg-[#FFA168] hover:bg-orange-400 rounded-full shrink-0 grow-0 mr-4 dark:bg-gray-600 hide"
                                        type="button"
                                        id="{{ $member->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white transform rotate-180" id="svgPlus{{ $member->id }}">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        <svg class="h-6 w-6 text-white" style="display: none" id="svgMinus{{ $member->id }}"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="5" y1="12" x2="19" y2="12" /></svg>
                                    </button>
                                    <a class="w-auto p-4 shadow-lg hover:shadow-2xl rounded-lg dark:bg-neutral-700 dark:text-neutral-50 inline-flex"
                                       href="{{ url("member/account/$member->id") }}" id="bgColor-{{ $count }}">
                                        <div class="flex items-center space-x-4 sp">
                                            <div class="inline-flex items-center justify-center w-8 h-8 rounded-full shrink-0 grow-0 dark:bg-gray-600" id="parentColor-{{ $count }}">
                                                <span class="font-bold text-xl text-white">{{$count}}</span>
                                            </div>
                                            <div class="inline-flex items-center justify-center w-14 h-14 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600">
                                                @if ($member->profile_image)
                                                    <img src="{{ asset('uploads/users/' .$member->profile_image)}}" id="profile_pic_preview" class="inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                                                @else
                                                    <img src="{{url('/img/profile.png')}}" id="profile_pic_preview" class="inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                                                @endif
                                            </div>
                                            <div class="font-semibold dark:text-white">
                                                <div class=" text-md">{{$member->name}}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{$member->email}}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4 ml-12">
                                            <div class="font-semibold dark:text-white">
                                                <div class=" text-md">{{$member->rank->rank_short_form}}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">@lang('public.rank')</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4 ml-12">
                                            <div class="font-semibold dark:text-white">
                                                <div class=" text-md">${{number_format($member->wallet_balance, 2)}}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">@lang('public.wallet_balance')</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4 ml-12">
                                            <div class="font-semibold dark:text-white">
                                                <div class=" text-md">${{number_format($member->personalDeposits(), 2)}}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">@lang('public.total_personal_deposit')</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4 ml-12">
                                            <div class="font-semibold dark:text-white">
                                                <div class=" text-md">${{number_format($member->groupTotalDeposit(), 2)}}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">@lang('public.total_group_deposit')</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4 ml-12">
                                            <div class="font-semibold dark:text-white">
                                                <div class=" text-md">{{$member->getClientsCount()}}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">@lang('public.direct_downlines')</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="!visible hidden hideContent-{{ $member->id }} ml-6 childContainer" id="collapseExample-{{$member->id}}" data-te-collapse-item>
                                    @include('components.child', [
                                    'children' => $member->children,
                                    'count' => $count
                                    ])
                                </div>
                            @else
                                <div class="inline-flex mb-4 hover:shadow-2xl">
                                    <a
                                        class="w-auto p-4 shadow-lg rounded-lg dark:bg-neutral-700 dark:text-neutral-50 inline-flex"
                                        href="{{ url("member/account/$member->id") }}" id="bgColor-{{ $count }}">
                                        <div class="flex items-center space-x-4 sp">
                                            <div class="inline-flex items-center justify-center w-8 h-8 rounded-full shrink-0 grow-0 dark:bg-gray-600" id="parentColor-{{ $count }}">
                                                <span class="font-bold text-md text-white">{{$count}}</span>
                                            </div>
                                            <div class="inline-flex items-center justify-center w-14 h-14 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600">
                                                @if ($member->profile_image)
                                                    <img src="{{ asset('uploads/users/' .$member->profile_image)}}" id="profile_pic_preview" class="inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-green-500 rounded-full shrink-0 grow-0 dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                                                @else
                                                    <img src="{{url('/img/profile.png')}}" id="profile_pic_preview" class="inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-green-500 rounded-full shrink-0 grow-0 dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                                                @endif
                                            </div>
                                            <div class="font-semibold dark:text-white">
                                                <div class=" text-md">{{$member->name}}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{$member->email}}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4 ml-12">
                                            <div class="font-semibold dark:text-white">
                                                <div class=" text-md">{{$member->rank->rank_short_form}}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">@lang('public.rank')</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4 ml-12">
                                            <div class="font-semibold dark:text-white">
                                                <div class=" text-md">${{number_format($member->wallet_balance, 2)}}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">@lang('public.wallet_balance')</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4 ml-12">
                                            <div class="font-semibold dark:text-white">
                                                <div class=" text-md">${{number_format($member->personalDeposits(), 2)}}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    @lang('public.total_personal_deposit')
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4 ml-12">
                                            <div class="font-semibold dark:text-white">
                                                <div class=" text-md">${{number_format($member->groupTotalDeposit(), 2)}}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">@lang('public.total_group_deposit')</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4 ml-12">
                                            <div class="font-semibold dark:text-white">
                                                <div class=" text-md">{{$member->getClientsCount()}}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">@lang('public.direct_downlines')</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            @endif
                        @endforeach
                    @else
                        <div class="w-full flex p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800" role="alert">
                            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">@lang('public.info')</span>
                            <div>
                                <span class="font-medium">@lang('public.info'):</span> @lang('public.no_record')
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(e) {
            var color = ["#DB93A5", "#C3B8AA", "#698396", "#C6AC85", "#874741", "#98df8a", "#d62728", "#ff9896", "#9467bd", "#c5b0d5", "#8c564b", "#c49c94", "#e377c2", "#f7b6d2", "#7f7f7f", "#c7c7c7", "#bcbd22", "#dbdb8d", "#aec7e8", "#9edae5", "#393b79", "#5254a3", "#6b6ecf", "#9c9ede", "#637939", "#8ca252", "#b5cf6b", "#8c6d31", "#bd9e39", "#e7ba52", "#843c39", "#ad494a", "#d6616b", "#e7969c", "#7b4173", "#a55194", "#ff7f0e", "#de9ed6", "#3182bd", "#6baed6", "#9ecae1", "#c6dbef", "#e6550d", "#fd8d3c", "#fdae6b", "#fdd0a2", "#31a354", "#74c476", "#a1d99b", "#c7e9c0"]

            var bgColor = ["#FBECDB", "#F3CBBD", "#E6D1D2", "#DAD5D6", "#CCD4BF", "#B6D8F2", "#F4CFDF", "#D2D4EC", "#E4D9FF", "#F3D1FF", "#FFE6FF", "#FFE9E6", "#FFF0F5", "#F6F1D1", "#FDF0D5", "#E4F4B2", "#C4E4D9", "#B1C7D9", "#C3B8E9", "#F7DDE9", "#FFDEE1", "#FFF4E6", "#FFF8DC", "#C5E5E9", "#BEE9E2", "#FFECF5", "#FCEFF9", "#FFE3E3", "#F5C3C2", "#FFC5B5", "#FFE08C", "#F8E09C", "#BEEB9F", "#9ED2D6", "#D2A5D5", "#E1B1A7", "#FFC6A9", "#FFA69E", "#ECD5E3", "#D4E6F1", "#A9D0F5", "#C6B1E6", "#F2C2CD", "#F4B3B2", "#F4CD9B", "#E3D3B3", "#D3E2C3", "#C9E4F5", "#AACCEA", "#B6A1E6", "#D2A8FF", "#A9B4FF", "#D4A8E8", "#D2C4A4", "#BFD4BF", "#A9D4D4"]

            $("#parentContainer #parentColor-{{ @$count }}").each(function(i) {
                $(this).css('background', color[{{@$count - 1}}]);
            });

            $("#parentContainer #bgColor-{{ @$count }}").each(function(i) {
                $(this).css('background', bgColor[{{@$count - 1}}]);
            });

            let counter = 1;
            while (counter <= 100) {
                counter = counter + 1;
                $("#childContainer #childColor-"+counter).each(function(i) {
                    $(this).css('background', color[counter - 1]);
                });

                $("#childContainer #childBg-"+counter).each(function(i) {
                    $(this).css('background', bgColor[counter - 1]);
                });
            }

            $('.hide').on('click', function() {
                var id = $(this).attr('id');
                $(".hideContent-"+id).toggle('fast');
                $('#svgPlus'+id).toggle('fast');
                $('#svgMinus'+id).toggle('fast');
            });

            $('.hide-child').on('click', function() {
                var id = $(this).attr('id');
                $(".hideContent-"+id).toggle('fast');
                $('#svgPlus-child'+id).toggle('fast');
                $('#svgMinus-child'+id).toggle('fast');
            });
        });
    </script>
@endsection
