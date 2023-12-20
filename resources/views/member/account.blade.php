@extends('layouts.master-member')

@section('title') Network Tree - Account @endsection

@section('contents')
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-lg font-semibold">
                <li class="inline-flex items-center">
                <a href="#" class="inline-flex items-center text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 mr-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                </svg>
                @lang('public.network_tree')
                </a>
                </li>
                <li>
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <p href="#" class="ml-1  text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">{{$user->name}}</p>
                </div>
                </li>
            </ol>
        </nav>
        <div class=" w-auto ">
            <div class="px-4">
                <div class="flex py-6 max-[1000px]:flex-col justify-center items-center">
                    <div class="flex items-center space-x-4 mb-4 ">
                        @if ($user->profile_image)
                            <img src="{{ asset('uploads/users/' .$user->profile_image)}}" class="w-12 h-12 rounded-full bg-blue-500 "></img>
                        @else
                            <img src="{{url('/img/profile.png')}}" class="w-12 h-12 rounded-full bg-blue-400"></img>
                        @endif
                        <div class="font-semibold text-blue-400 text-lg">
                            <div>{{$user->name}}</div>
                            <span class="text-md text-gray-500 dark:text-gray-400">{{$user->email}}</span>
                        </div>
                    </div>
                    <div class=" items-center ml-12 font-semibold text-blue-400 text-xl mb-4 max-[1150px]:ml-8">
                        <div>@lang('public.rank') :</div>
                        <span class="text-lg text-gray-500 dark:text-gray-400">{{$user->rank->name}}</span>
                    </div>
                    <a href="{{ url("member/deposit/$user->id") }}" class="max-[1150px]:justify-center max-w-xs max-[1150px]:ml-8 ml-auto text-white bg-blue-400 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-500 font-semibold rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-6 h-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="ml-2 text-md text-white">@lang('public.view_deposit')</span>
                    </a>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-md text-left text-gray-700 dark:text-gray-400">
                        <thead class="border-b-4 text-sm text-gray-700 uppercase dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 bg-blue-100 dark:bg-gray-800">
                                    @lang('public.broker')
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    @lang('public.total_personal_deposit')
                                </th>
                                <th scope="col" class="px-6 py-3 bg-blue-100 dark:bg-gray-800">
                                    @lang('public.total_group_deposit')
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    @lang('public.total_rebate_personal_deposit')
                                </th>
                                <th scope="col" class="px-6 py-3 bg-blue-100 dark:bg-gray-800">
                                    @lang('public.total_rebate_group_deposit')
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    @lang('public.total_downline')
                                </th>
                                <th scope="col" class="px-6 py-3 bg-blue-100 dark:bg-gray-800">
                                    @lang('public.total_clients')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($brokers as $broker)
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-blue-600 whitespace-nowrap bg-blue-100 dark:text-white dark:bg-gray-800">
                                    {{$broker->name}}
                                </th>
                                <td class="px-6 py-4">
                                    ${{number_format($broker->data['personal_deposit'],2)}}
                                </td>
                                <td class="px-6 py-4 bg-blue-100 dark:bg-gray-800">
                                    ${{number_format($broker->data['group_deposit'],2)}}
                                </td>
                                <td class="px-6 py-4">
                                    ${{number_format($broker->data['personal_commissions'],2)}}
                                </td>
                                <td class="px-6 py-4 bg-blue-100 dark:bg-gray-800">
                                    ${{number_format($broker->data['group_commissions'],2)}}
                                </td>
                                <td class="px-6 py-4">
                                    {{$broker->data['downlines']}}
                                </td>
                                <td class="px-6 py-4 bg-blue-100 dark:bg-gray-800">
                                    {{$broker->data['clients']}}
                                </td>
                            </tr>

                        @endforeach

                            <tr class="border-t-4 border-gray-200 dark:border-gray-700 font-bold text-lg">
                                <th scope="row" class="px-6 py-4 font-bold text-blue-600 whitespace-nowrap bg-blue-100 dark:text-white dark:bg-gray-800">
                                    @lang('public.total'):
                                </th>
                                <td class="px-6 py-4">
                                    ${{number_format( $total['total_personal'],2)}}
                                </td>
                                <td class="px-6 py-4 bg-blue-100 dark:bg-gray-800">
                                    ${{number_format($total['total_group'],2)}}
                                </td>
                                <td class="px-6 py-4">
                                    ${{number_format($total['total_personal_comm'],2)}}
                                </td>
                                <td class="px-6 py-4 bg-blue-100 dark:bg-gray-800">
                                    ${{number_format($total['total_group_comm'],2)}}
                                </td>
                                <td class="px-6 py-4">

                                </td>
                                <td class="px-6 py-4 bg-blue-100 dark:bg-gray-800">

                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection
