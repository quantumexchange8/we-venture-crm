@extends('layouts.master-member')

@section('title') Report-{{ $title }} @endsection
@section('css')
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet" />
@endsection
@section('contents')
    @if($errors->any())
        @foreach($errors->all() as $key => $error)
            <div class="flex p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">@lang('public.error_icon')</span>
                <div>
                    <span class="font-medium">{{ $error }}</span>
                </div>
            </div>
        @endforeach
    @endif
    <h1 class="font-semibold text-2xl text-gray-500"> @lang('public.deposit_downline')</h1>

    <!-- component -->
    <div class="flex flex-col">
        <form method="post" action="{{ route('daily_monthly_deposits_listing') }}">
            @csrf
            <div class="grid gap-6 mb-6 mt-4 grid-cols-3 max-[1600px]:grid-cols-2 max-[1100px]:grid-cols-1">
                <div class="relative">
                    <select  class="js-example-basic-single w-full" name="user_id" >
                        <option selected value="">@lang('public.select_user')</option>
                        @foreach($users as $user)
                            <option {{  @$search['user_id'] == $user->id ? "selected" : "" }} value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div date-rangepicker datepicker-format="yyyy/mm/dd" class="flex items-center" id="transaction_date">
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

                <div class="max-[655px]:flex max-[655px]:flex-col gap-2" id="filter_month">
                    {!! Form::select('filter_month', $get_filter_month, @$search['filter_month'], ['class' => 'bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500']) !!}
                </div>
                <div class="max-[655px]:flex max-[655px]:flex-col gap-2" id="filter_year">
                    {!! Form::select('filter_year', $get_filter_year, @$search['filter_year'], ['class' => 'bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500']) !!}
                </div>

                <div class="max-[655px]:flex max-[655px]:flex-col gap-2">
                    <select id="filter_type" name="filter_type" class="bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500">
                            <option selected {{ @$search['filter_type'] == 'daily' ? 'selected' : '' }} value="daily">@lang('public.daily')</option>
                        <option {{ @$search['filter_type'] == 'monthly' ? 'selected' : '' }} value="monthly">@lang('public.monthly')</option>
                    </select>
                </div>
                <div class="max-[755px]:flex max-[755px]:flex-col gap-2">
                    <button type="submit" class="text-white bg-primary hover:bg-primary-600 border border-primary-200 focus:ring-4 focus:outline-none focus:ring-primary-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" name="submit" value="search">@lang('public.search')</button>
                    <button type="submit" class="text-white bg-rose-500 hover:bg-rose-600 border border-rose-200 focus:ring-4 focus:outline-none focus:ring-rose-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" name="submit" value="reset">@lang('public.reset')</button>

                    <a  class=" text-white py-2 px-5 rounded rounded bg-[#FFA168] hover:bg-orange-400 text-md font-bold float-right">
                        <div class="flex items-center justify-center">
                            <svg class="h-6 w-6 text-white mr-2"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />  <polyline points="17 8 12 3 7 8" />  <line x1="12" y1="3" x2="12" y2="15" /></svg>
                            <button type="submit" name="submit" value="export"  class=" text-md font-bold">@lang('public.export_report')</button>
                        </div>
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if($records->isNotEmpty())
            <?php
            $no = $records->firstItem();
            ?>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-2">
            <table class="w-full text-left">
                <thead class="uppercase bg-[#FDFCF3] text-sm">
                <tr>
                    <th scope="col" class="p-4 text-center">
                        #
                    </th>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            @sortablelink('transaction_at', trans('public.date'))
                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            @sortablelink('user.name', trans('public.name'))
                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            @sortablelink('user.email', trans('public.email'))
                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            @sortablelink('broker.name', trans('public.broker'))
                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            @lang('public.deposit_amount')
                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            @lang('public.deposit_withdrawal_amount')
                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>


                </tr>
                </thead>
                <tbody>
                @foreach($records as $record)
                    <tr class="border-b odd:bg-[#F6F6F6] even:bg-[#FDFCF3] text-sm">
                        <th scope="row" class="p-4 text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $no }}
                        </th>
                        <td class="p-4">
                            {{ $record->month_year ?? $record->date }}
                        </td>
                        <td class="p-4">
                            <a href="{{ route('view_member_profile', $record->user->id) }}" class="underline text-[#1A8BFF]">{{ $record->user->name }}</a>
                        </td>
                        <td class="p-4">
                            {{ $record->user->email }}
                        </td>
                        <td class="p-4">
                            {{ $record->broker->name }}
                        </td>
                        <td class="p-4">
                            <span class="text-success font-semibold"> {{ number_format($record->dep_amount, 2) }} </span>
                        </td>
                        <td class="p-4">
                            <span class="text-danger font-semibold"> {{ number_format($record->with_total, 2) }} </span>
                        </td>
                    </tr>
                    <?php
                        $no++;
                    ?>
                @endforeach
                </tbody>
            </table>
            <!-- pagination -->
            <div class="m-4">
                <span class="float-right font-bold"> @lang('public.total'):  ${{ number_format($total, 2) }}</span> <br><br>
                {!! $records->links('pagination::tailwind') !!}
            </div>
        </div>
    @else
        <div class="flex p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">@lang('public.info')</span>
            <div>
                <span class="font-medium">@lang('public.info') :</span>@lang('public.no_record')
            </div>
        </div>
    @endif



@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>

        $(document).ready(function(e){
            $('.js-example-basic-single').select2();


        var type = $('#filter_type').val();
            display_filtering();

        $('#filter_type').on('change', function() {
            type = this.value;
            display_filtering();
        });


        function display_filtering() {
            if(type == 'monthly') {
                $('#transaction_date').hide();
                $('#filter_month').show();
                $('#filter_year').show();
            } else {
                $('#filter_month').hide();
                $('#filter_year').hide();
                $('#transaction_date').show();
            }
        }
        })



    </script>

@endsection

