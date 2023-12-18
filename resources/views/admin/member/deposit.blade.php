@extends('layouts.master-admin')

@section('title') Member Deposit @endsection

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
    <div class="flex flex-row">
        <h1 class="flex-1 font-semibold text-2xl text-gray-500">@lang('public.members') / {{ $user->name }} - @lang('public.deposits')</h1>
        <a href="{{ route('member_details', $user->id) }}" class="font-semibold text-xl text-[#FFA168]">@lang('public.back')</a>
    </div>
    <div class="mt-8 grid grid-flow-row grid-flow-cols grid-cols-3 gap-3 my-4 max-[1200px]:grid-rows-auto max-[1200px]:grid-cols-none ">
        <div class="relative overflow-x-auto max-[1200px]:col-span-3 mb-4">
            <table class="w-full text-sm text-left border-2 border-orange-300 bg-[#FDFCF3] shadow-lg text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="flex items-center justify-center bg-[#FDFCF3]">
                        <div class="my-6 relative inline-flex items-center justify-center w-28 h-28 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600">
                            @if ($user->profile_image)
                                <img src="{{ asset('uploads/users/' .$user->profile_image)}}" id="profile_pic_preview" class="relative inline-flex items-center justify-center w-28 h-28 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl">
                            @else
                                <img src="{{url('/img/profile.png')}}" id="profile_pic_preview" class="relative inline-flex items-center justify-center w-28 h-28 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl">
                            @endif
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center text-xl">
                            <div class="font-bold">{{ $user->name }}</div>
                            <div class="mb-4 text-[#FFA168] font-semibold">${{ number_format($total_deposit, 2) }}</div>
                        </td>
                    </tr>
                    @foreach($deposit_by_group as $deposit_group)
                        <tr class="border border-orange-300">
                            <td class="flex items-center justify-center">
                                <span class="m-4">{{ $deposit_group->broker->name }} : <b>${{ number_format($deposit_group->amount, 2) }}</b></span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="w-11/12 col-span-2 ml-4">
            <form method="post" action="{{ route('member_deposit', $user->id) }}">
                @csrf
                <div class="grid gap-6 grid-cols-2 max-[900px]:grid-cols-1">
                    <div class="w-full">
                        {!! Form::select('brokersId', $get_broker_sel, @$search['brokersId'], ['class' => 'bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500']) !!}
                    </div>
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
                    <div class="flex">
                        <button type="submit" class="mr-4 text-white bg-primary hover:bg-primary-600 border border-primary-200 focus:ring-4 focus:outline-none focus:ring-primary-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" name="submit" value="search">@lang('public.search')</button>
                        <button type="submit" class="mr-4 text-white bg-rose-500 hover:bg-red-600 border border-red-200 focus:ring-4 focus:outline-none focus:ring-red-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" name="submit" value="reset">@lang('public.reset')</button>
                        <button data-modal-target="fundAdjustmentModal" data-modal-toggle="fundAdjustmentModal" class="block text-white bg-[#40DD7F] hover:bg-success-600 focus:ring-4 focus:outline-none focus:ring-success-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-success-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                            @lang('public.fund_adjustment')
                        </button>
                    </div>
                </div>
            </form>
            @if($deposits->isNotEmpty())
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-8 border-2">
                    <table class="w-full text-left text-sm">
                        <thead class="font-bold">
                        <tr>
                            <th scope="col" class="px-6 py-6">
                                <div class="flex items-center">
                                    @sortablelink('transaction_at', trans('public.date'))
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-6">
                                <div class="flex items-center">
                                    @sortablelink('broker.name', trans('public.broker'))
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-6">
                               @lang('public.pamm')
                            </th>
                            <th scope="col" class="px-6 py-6">
                                <div class="flex items-center">
                                    @sortablelink('type', trans('public.type'))
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-6">
                                <div class="flex items-center">
                                    @sortablelink('amount', trans('public.amount'))
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($deposits as $deposit)
                                <tr class="border-b odd:bg-[#F6F6F6] even:bg-[#FDFCF3]">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $deposit->transaction_at }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $deposit->broker->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $deposit->pamm->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-primary-600 uppercase font-semibold">
                                        @switch($deposit->type)
                                            @case(\App\Models\Deposits::TYPE_DEPOSIT)
                                                <span class="text-primary font-semibold uppercase">@lang('public.type_deposit')</span>
                                                @break

                                            @case(\App\Models\Deposits::TYPE_WITHDRAW)
                                                <span class="text-danger font-semibold uppercase">@lang('public.withdraw')</span>
                                                @break

                                            @default
                                                <span class="text-primary font-semibold uppercase">@lang('public.type_deposit')</span>
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4">
                                        ${{ $deposit->amount }}
                                    </td>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- pagination -->
                    <div class="m-4">
                        {!! $deposits->links('pagination::tailwind') !!}
                    </div>
                </div>
            @else
                <div class="flex p-4 mt-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
                    <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">@lang('public.info')</span>
                    <div>
                        <span class="font-medium">@lang('public.info') :</span>@lang('public.no_record')
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Fund Adjustment modal -->
    <div id="fundAdjustmentModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="fundAdjustmentModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-orange-400 dark:text-white">@lang('public.fund_adjustment')</h3>

                    <form class="space-y-6" method="post" action="{{ route('fund_adjustmnent') }}" id="adjustment-modal">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <ul class="grid w-full gap-6 md:grid-cols-2 mb-4">
                            <li>
                                <input type="radio" id="deposit_amount" name="type" value="1" class="hidden peer">
                                <label for="deposit_amount" class="inline-flex items-center justify-center w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-orange-500 peer-checked:text-orange-400 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                    <div class="block">
                                        <div class="w-full text-lg font-semibold">@lang('public.deposit_amount')</div>
                                    </div>
                                </label>
                            </li>
                            <li>
                                <input type="radio" id="withdraw_amount" name="type" value="2" class="hidden peer">
                                <label for="withdraw_amount" class="inline-flex items-center justify-center w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-orange-500 peer-checked:text-orange-400 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                    <div class="block">
                                        <div class="w-full text-lg font-semibold">@lang('public.withdrawal_amount') @if($user->withdrawal_action == \App\Models\User::DISABLE_WITHDRAWAL)
                                                <span class="inline-block whitespace-nowrap rounded-[0.27rem] bg-yellow-100 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center align-baseline text-[0.75em] font-bold leading-none text-yellow-700">
                                @lang('public.disable')
                            </span>
                                            @elseif($user->withdrawal_action == \App\Models\User::ENABLE_WITHDRAWAL)
                                                <span class="inline-block whitespace-nowrap rounded-[0.27rem] bg-success-100 px-[0.65em] pb-[0.25em] pt-[0.35em] text-center align-baseline text-[0.75em] font-bold leading-none text-success-700">
                                @lang('public.enable')
                            </span>
                                            @endif</div>
                                    </div>
                                </label>
                            </li>
                        </ul>
                        <span class="text-danger mb-4 text-xs error-text type_error"></span>
                        <div>
                            <label for="brokersId" class="block mb-2 text-md font-medium text-[#FFA168] dark:text-white">@lang('public.brokers')</label>
                            {!! Form::select('brokersId', $get_broker_sel, @old('brokersId'), ['class' => 'bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500']) !!}
                            <span class="text-danger text-xs error-text brokersId_error"></span>
                        </div>
                        <div>
                            <label for="pamm_id" class="block mb-2 text-md font-medium text-[#FFA168] dark:text-white">@lang('public.pamm')</label>
                            {!! Form::select('pamm_id', $get_pamm_sel, @old('pamm_id'), ['class' => 'bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500', 'placeholder' => trans('public.select_pamm')]) !!}
                            <span class="text-danger text-xs error-text pamm_id_error"></span>
                        </div>
                        <div>
                            <label for="amount" class="block mb-2 text-md font-medium text-[#FFA168] dark:text-white">@lang('public.amount')</label>
                            <input type="number" name="amount" id="amount" placeholder="0.00" class="bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" autocomplete="off" min="1">
                            <span class="text-danger text-xs error-text amount_error"></span>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="text-white bg-[#40DD7F] hover:bg-green-400 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                <svg class="h-6 w-6 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r="9" />  <path d="M9 12l2 2l4 -4" /></svg>
                                <span class="ml-2">@lang('public.delete_confirmed')</span>
                            </button>
                            <button type="button" class="text-white bg-[#FF6262] hover:bg-red-400 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" data-modal-hide="fundAdjustmentModal">
                                <svg class="h-6 w-6 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="15" y1="9" x2="9" y2="15" />  <line x1="9" y1="9" x2="15" y2="15" /></svg>
                                <span class="ml-2">@lang('public.delete_cancel')</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#adjustment-modal').on('submit', function(e) {
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
                        console.log(data)
                        if(data.status === 0) {
                            $.each(data.error, function (prefix, val){
                                $('span.'+prefix+'_error').text(val[0]);
                                $('.'+prefix).addClass('border-danger');
                            });
                        } else if (data.status == 2) {
                            Swal.fire({
                                title: '{{ trans('public.invalid_action') }}',
                                text: data.msg,
                                icon: 'error',
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
                    error: function(error) {
                        console.log(error)
                        Swal.fire({
                            title: 'Error!',
                            text: error,
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
