@extends('layouts.master-admin')

@section('title') Referral-Referral Tree @endsection

@section('contents')
    <div class="flex flex-row">
        <h1 class="flex-1 font-semibold text-lg text-gray-500">@lang('public.referrals') / @lang('public.referrals_tree')  / {{ $user->name }}</h1>
    </div>

    <div class="mt-8 rounded-lg dark:border-gray-700">
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="flex flex-col p-4 text-center justify-between items-center bg-blue-100 border border-blue-300 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-blue-100 hover:shadow-lg dark:border-blue-700 dark:bg-blue-800 dark:hover:bg-blue-700">
                <div class="inline-flex items-center my-4 justify-center w-16 h-16 overflow-hidden bg-black-400 rounded-full shrink-0 grow-0 dark:bg-blue-600">
                    @if ($user->profile_image)
                        <img src="{{ asset('uploads/users/' .$user->profile_image)}}" id="profile_pic_preview" class="inline-flex items-center justify-center w-16 h-16 overflow-hidden bg-blue-400 rounded-full shrink-0 grow-0 dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                    @else
                        <img src="{{url('/img/profile.png')}}" id="profile_pic_preview" class="inline-flex items-center justify-center w-16 h-16 overflow-hidden bg-blue-400 rounded-full shrink-0 grow-0 dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                    @endif
                </div>
                <div class="flex flex-col mx-4">
                    <h2 class="font-semibold text-lg text-blue-500 mb-2">{{ $user->name }}</h2>
                    <span class="text-md text-gray-500 md:w-full w-28 break-words">
                            {{ $user->email }}
                    </span>
                </div>
                <div>
                    <h2 class="font-semibold text-lg text-blue-500 mb-2">{{ $user->rank->name }}</h2>
                    <span class="text-md text-gray-500">
                        @lang('public.rank')
                    </span>
                </div>
            </div>
            <div class="flex flex-col p-10 items-center justify-between text-center bg-blue-100 border border-blue-300 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-blue-100 hover:shadow-lg dark:border-blue-700 dark:bg-blue-800 dark:hover:bg-blue-700">
                <div class="flex flex-col mx-4">
                    <h2 class="font-semibold text-lg text-gray-500 mb-2">@lang('public.total_clients')</h2>
                    <span class="font-semibold text-md text-blue-500">
                            {{ $user->getClientsCount() }}
                    </span>
                </div>
                <div>
                    <h2 class="font-semibold text-lg text-gray-500 mb-2">@lang('public.total_downline')</h2>
                    <span class="font-semibold text-md text-blue-500">
                            {{ $user->getDownlinesCount() }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-8">
        <table class="w-full text-sm text-left text-gray-700 dark:text-gray-400">
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
                    <th scope="row" class="px-6 py-4 font-medium text-blue-500 whitespace-nowrap bg-blue-100 dark:text-white dark:bg-gray-800">
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

            <tr class="border-t-4 border-gray-200 dark:border-gray-700 font-bold text-lg text-sm">
                <th scope="row" class="px-6 py-4 font-bold text-blue-500 whitespace-nowrap bg-blue-100 dark:text-white dark:bg-gray-800">
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


@endsection
