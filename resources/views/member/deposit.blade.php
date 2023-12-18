@extends('layouts.master-member')

@section('title') Network Tree - Member Deposit @endsection

@section('contents')

        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-lg font-semibold">
                <li class="inline-flex items-center">
                <a href="#" class="inline-flex items-center text-gray-700 hover:text-orange-600 dark:text-gray-400 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 mr-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                </svg>
                    @lang('public.network_tree')
                </a>
                </li>
                <li>
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <a href="#" class="ml-1  text-gray-700 hover:text-orange-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">{{$user->name}}</a>
                </div>
                </li>
                <li>
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <p href="#" class="ml-1  text-gray-700 hover:text-orange-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">@lang('public.view_deposit')</p>
                </div>
                </li>
            </ol>
        </nav>
        <div class="grid grid-cols-6 w-auto max-[1250px]:grid-cols-4">
            <div class="col-span-4 px-4">
            <form  action="{{ url("member/deposit/$user->id") }}" method="post"  class="flex max-[1250px]:flex-col gap-3 mb-4">
                @csrf
                <div date-rangepicker datepicker-format="yyyy/mm/dd" class="flex items-center">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="text" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-blue-500" placeholder="@lang('public.select_start_date')" autocomplete="off" name="transaction_start" value="{{ @$search['transaction_start'] }}">
                    </div>
                    <span class="mx-4 text-gray-500">@lang('public.to')</span>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="text" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-blue-500" placeholder="@lang('public.select_end_date')" autocomplete="off" name="transaction_end" value="{{ @$search['transaction_end'] }}">
                    </div>
                </div>
                <div class="w-4/12 mr-4  max-[1250px]:w-full">
                    <select id="broker" name="filter_broker" class="bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500">
                        <option selected value="all">@lang('public.select_broker')</option>
                        @foreach($brokers as $broker)
                            <option {{ @$search['filter_broker'] == $broker->id ? 'selected' : '' }} value="{{ $broker->id }}">{{ $broker->name}}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" name="submit" value="search" class="max-[1250px]:justify-center text-white bg-orange-500 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-lg p-2.5 text-center inline-flex items-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </button>
                <button type="submit" name="submit" value="reset" class="max-[1250px]:justify-center text-white bg-rose-500 hover:bg-rose-800 focus:ring-4 focus:outline-none focus:ring-rose-300 font-medium rounded-lg text-lg p-2.5 text-center inline-flex items-center dark:bg-rose-600 dark:hover:bg-rose-700 dark:focus:ring-rose-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                    </svg>
                </button>

                </form>

                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-md text-left text-gray-500">
                        <thead class="text-md text-orange-500 uppercase border-b">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    @sortablelink('transaction_at', trans('public.date'))
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    @sortablelink('brokersId', trans('public.broker'))
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex items-center">
                                    @sortablelink('amount', trans('public.amount'))
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody >
                        @foreach($deposits as $data)
                            <tr class="odd:bg-white even:bg-[#FDFCF3] border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $data->transaction_at }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $data->broker->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ number_format($data->amount,2) }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class=" m-4">
                <!-- Help text -->
                    <span class="text-sm text-gray-700 dark:text-gray-400">
                        @if(count($deposits) > 0)
                            <div class="my-4">
                                {!! $deposits->links('pagination::tailwind') !!}
                            </div>
                        @else
                            <div class="w-full flex p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800" role="alert">
                            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">@lang('public.info')</span>
                            <div>
                                <span class="font-medium">@lang('public.info') :</span>@lang('public.no_record')
                            </div>
                        </div>

                        @endif
                </span>
                </div>
            </div>
            <div class="col-span-2 px-4  max-[1250px]:col-span-4">
                <div class=" bg-[#FDFCF3] border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mx-auto text-center pb-4">
                    <div class="py-12 bg-orange-500 w-full rounded-lg">
                        <h5 class="text-3xl font-semibold tracking-tight text-slate-50">{{$user->name}}: </h5>
                        <h5 class=" text-2xl font-semibold tracking-tight text-slate-50">$ {{number_format($personal_total,2)}}</h5>
                    </div>
                    @if ($user->profile_image)
                        <img src="{{ asset('uploads/users/' .$user->profile_image)}}" class="rounded-full -mt-10 w-20 h-20 mx-auto text-orange-500 bg-rose-200 p-2 drop-shadow-2xl mb-2"></img>
                    @else
                        <img src="{{url('/img/profile.png')}}" class="rounded-full -mt-10 w-20 h-20 mx-auto text-orange-500 bg-rose-200 p-2 drop-shadow-2xl mb-2"></img>
                    @endif
                    <div class=" bg-[#FDFCF3] w-full rounded-lg">
                        @foreach($broker_group as $group)
                            <div class="p-2">
                                <h5 class="text-xl font-semibold tracking-tight text-orange-500"> {{$group->broker->name}} </h5>
                                <h5 class=" text-2xl font-semibold tracking-tight text-gray-800">$ {{number_format($group->amount,2)}}</h5>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

@endsection
