@extends('layouts.master-admin')

@section('title') {{ $title }} @endsection

@section('contents')
    <h1 class="font-semibold text-2xl text-gray-500">@lang('public.referrals') / @lang('public.referrals_tree')</h1>

    <!-- search -->
    <div class="flex flex-col">
        <form method="post" action="{{ route('referral_tree') }}">
            @csrf
            <div class="grid gap-6 mb-6 mt-4 md:grid-cols-1">
                <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" id="search" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-blue-500" placeholder="@lang('public.search_email')" name="freetext" value="{{ @$search['freetext'] }}">
                </div>
                <div class="max-[755px]:flex max-[755px]:flex-col gap-2">
                    <button type="submit" class="text-white bg-primary hover:bg-primary-600 border border-primary-200 focus:ring-4 focus:outline-none focus:ring-primary-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" name="submit" value="search">@lang('public.search')</button>
                    <button type="submit" class="text-white bg-rose-500 hover:bg-rose-600 border border-rose-200 focus:ring-4 focus:outline-none focus:ring-rose-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-rose-600 dark:hover:bg-rose-700 dark:focus:ring-rose-800" name="submit" value="reset">@lang('public.reset')</button>
                    <a href="#" class=" text-white py-2 px-5 rounded rounded bg-[#FFA168] hover:bg-orange-400 text-md font-bold float-right">
                        <div class="flex items-center justify-center">
                            <svg class="h-6 w-6 text-white mr-2"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />  <polyline points="17 8 12 3 7 8" />  <line x1="12" y1="3" x2="12" y2="15" /></svg>
                            <button type="submit" name="submit" value="export"  class=" text-md font-bold">@lang('public.export_report')</button>
                        </div>
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if($members->isNotEmpty())
        <div class="relative overflow-x-auto lg:max-w-[972px] xl:max-w-[1100px] 2xl:max-w-[1200px]" id="parentContainer">
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
                           href="{{ route('referral_detail', $member->id) }}" id="bgColor-{{ $count }}">
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
                    <div class="!visible hidden hideContent-{{ $member->id }} ml-6" id="collapseExample-{{$member->id}}" data-te-collapse-item>
                        @include('admin.referral.child', [
                        'children' => $member->children,
                        'count' => $count
                        ])
                    </div>
                @else
                    <div class="inline-flex mb-4 hover:shadow-2xl">
                        <a
                            class="w-auto p-4 shadow-lg rounded-lg dark:bg-neutral-700 dark:text-neutral-50 inline-flex"
                            href="{{ route('referral_detail', $member->id) }}" id="bgColor-{{ $count }}">
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


        </div>
    @else
        <div class="flex p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
            <div>
                <span class="font-medium">@lang('public.info') :</span>@lang('public.no_record')
            </div>
        </div>
    @endif

@endsection

@section('script')

    <script>
        $(document).ready(function(e) {
            var color = ["#DB93A5", "#C3B8AA", "#698396", "#C6AC85", "#874741", "#98df8a", "#d62728", "#ff9896", "#9467bd", "#c5b0d5", "#8c564b", "#c49c94", "#e377c2", "#f7b6d2", "#7f7f7f", "#c7c7c7", "#bcbd22", "#dbdb8d", "#aec7e8", "#9edae5", "#393b79", "#5254a3", "#6b6ecf", "#9c9ede", "#637939", "#8ca252", "#b5cf6b", "#8c6d31", "#bd9e39", "#e7ba52", "#843c39", "#ad494a", "#d6616b", "#e7969c", "#7b4173", "#a55194", "#ff7f0e", "#de9ed6", "#3182bd", "#6baed6", "#9ecae1", "#c6dbef", "#e6550d", "#fd8d3c", "#fdae6b", "#fdd0a2", "#31a354", "#74c476", "#a1d99b", "#c7e9c0"]

            var bgColor = ["#FBECDB", "#F3CBBD", "#E6D1D2", "#DAD5D6", "#CCD4BF", "#B6D8F2", "#F4CFDF", "#D2D4EC", "#E4D9FF", "#F3D1FF", "#FFE6FF", "#FFE9E6", "#FFF0F5", "#F6F1D1", "#FDF0D5", "#E4F4B2", "#C4E4D9", "#B1C7D9", "#C3B8E9", "#F7DDE9", "#FFDEE1", "#FFF4E6", "#FFF8DC", "#C5E5E9", "#BEE9E2", "#FFECF5", "#FCEFF9", "#FFE3E3", "#F5C3C2", "#FFC5B5", "#FFE08C", "#F8E09C", "#BEEB9F", "#9ED2D6", "#D2A5D5", "#E1B1A7", "#FFC6A9", "#FFA69E", "#ECD5E3", "#D4E6F1", "#A9D0F5", "#C6B1E6", "#F2C2CD", "#F4B3B2", "#F4CD9B", "#E3D3B3", "#D3E2C3", "#C9E4F5", "#AACCEA", "#B6A1E6", "#D2A8FF", "#A9B4FF", "#D4A8E8", "#D2C4A4", "#BFD4BF", "#A9D4D4"]

            $("#parentContainer #parentColor-{{ @$count }}").each(function(i) {
                $(this).css('background', color[{{ @$count - 1}}]);
            });

            $("#parentContainer #bgColor-{{ @$count }}").each(function(i) {
                $(this).css('background', bgColor[{{@$count - 1}}]);
            });

            let counter = 1;
            while (counter <= 500) {
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
