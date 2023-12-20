@extends('layouts.master-member')

@section('title')
    {{ $title }}
@endsection

@section('contents')

    <nav class="flex mb-4 max-[900px]:flex-col" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xl font-semibold mb-4">
            <li class="inline-flex items-center">
                <p href="#"
                   class="inline-flex items-center text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="h-8 w-8 text-gray-900 mr-2"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="4" y1="19" x2="20" y2="19" />  <polyline points="4 15 8 9 12 11 16 6 20 10" /></svg>
                    @lang('public.investment')
                </p>
            </li>
            <li>
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                              clip-rule="evenodd"></path>
                    </svg>
                    <p href="#"
                       class="ml-1  text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">
                        @lang('public.investment_plan')</p>
                </div>
            </li>
        </ol>

    </nav>
    <div class=" w-auto ">
        <div class="px-4"><form action="{{ route('investment.investment_plan') }}" method="post" class="grid grid-cols-2 gap-3 mb-4 max-[1450px]:grid-cols-2 max-[1100px]:grid-cols-1">
                @csrf
                <div date-rangepicker datepicker-format="yyyy/mm/dd" class="flex items-center">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="text" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="@lang('public.select_start_date')" autocomplete="off" name="created_start" value="{{ @$search['created_start'] }}">
                    </div>
                    <span class="mx-4 text-gray-500">@lang('public.to')</span>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="text" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="@lang('public.select_end_date')" autocomplete="off" name="created_end" value="{{ @$search['created_end'] }}">
                    </div>
                </div>
                <div class="w-full mr-4 ">
                    <select id="status" name="filter_status"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="all">@lang('public.filter_status')</option>
                        @foreach(\App\Models\Investment::status_listing() as $status)
                            <option {{ @$search['filter_status'] == $status ? 'selected' : '' }} value="{{ $status }}">{{ trans('public.'.$status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button data-tooltip-target="tooltip-search" type="submit" name="submit" value="search" class="mb-2 max-[1000px]:w-full justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg p-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                    <div id="tooltip-search" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        @lang('public.search')
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <button data-tooltip-target="tooltip-reset" type="submit" name="submit" value="reset" class="mb-2 max-[1000px]:w-full justify-center text-white bg-rose-500 hover:bg-rose-800 focus:ring-4 focus:outline-none focus:ring-rose-300 font-medium rounded-lg text-lg p-2.5 text-center inline-flex items-center mr-2 dark:bg-rose-600 dark:hover:bg-rose-700 dark:focus:ring-rose-800">
                        <svg class="h-4 w-4 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -5v5h5" />  <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 5v-5h-5" /></svg>
                    </button>
                    <div id="tooltip-reset" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        @lang('public.reset')
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>

            </form>

            <div class="relative overflow-x-auto sm:rounded-lg">
                <table class="w-full text-md text-left text-gray-500">
                    <thead class="text-md text-blue-500 uppercase border-b">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                @lang('public.portfolio')
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                @sortablelink('deposit_amount', trans('public.deposit_amount'))
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                @sortablelink('status', trans('public.status'))
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                @sortablelink('created_at', trans('public.date_submit'))
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex justify-center items-center">
                                @lang('public.action')
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($records as $record)
                        <tr class="odd:bg-white even:bg-blue-100 border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $record->portfolio->name }}
                            </th>
                            <td class="px-6 py-3">
                                ${{number_format($record->deposit_amount, 2)}}
                            </td>
                            <td class="px-6 py-3">
                                {{ trans('public.' . $record->status) }}
                            </td>
                            <td class="px-6 py-3">
                                {{ date_format($record->created_at, 'Y-m-d') }}
                            </td>
                            <td class="px-6 py-3">
                                <div class="flex justify-center gap-2">
                                    @if($record->status == 'processing')
                                        <a href="javascript:void(0)"
                                           class="edit_button"
                                           data-te-toggle="modal"
                                           data-te-target="#edit_plan-{{ $record->id }}"
                                           data-te-ripple-init
                                           data-te-ripple-color="light"
                                           data-investment-id="{{ $record->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 fill-primary hover:fill-primary-400">
                                                <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                            </svg>
                                        </a>
                                        <div id="tooltip-edit" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                            @lang('public.edit')
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                        @include('member.investment.edit_plan_modal')
                                    @else
                                        <span class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">@lang('public.done')</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <div class=" mt-4">
                <!-- Help text -->
                <span class="text-sm text-gray-700 dark:text-gray-400">
                    @if(count($records) > 0)
                        <div class="my-4">
                            {!! $records->links() !!}
                        </div>
                    @else
                        <div
                            class="w-full flex p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800"
                            role="alert">
                            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor"
                                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd"
                                                                                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                                                              clip-rule="evenodd"></path></svg>
                            <span class="sr-only">@lang('public.info')</span>
                            <div>
                                <span class="font-medium">@lang('public.info') :</span>@lang('public.no_record')
                            </div>

                    @endif
                </span>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.edit_button').on('click', function() {
                var investment_id = $(this).data('investment-id');
                var form = $('#edit_plan_'+investment_id);

                $(document).on('click', '#copyAdd', function() {
                    const copyText = document.getElementById("wallAdd");

                    if (copyText) {
                        const tempTextarea = document.createElement('textarea');
                        tempTextarea.value = copyText.value;
                        document.body.appendChild(tempTextarea);

                        tempTextarea.select();
                        tempTextarea.setSelectionRange(0, 99999); // For mobile devices

                        try {
                            document.execCommand('copy');
                            Swal.fire({
                                title: "{{ trans('public.success') }}",
                                text: "{{ trans('public.link_copied') }}",
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } catch (err) {
                            console.error('Error copying to clipboard:', err);
                            Swal.fire({
                                title: "Error",
                                text: "Unable to copy to clipboard",
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } finally {
                            document.body.removeChild(tempTextarea);
                        }
                    } else {
                        console.error('#wallAdd element not found');
                    }
                });

                // Remove any previous error messages and styling
                form.find('span.error-text').text('');
                form.find('.error').removeClass('border-danger');

                form.on('submit', function(e) {
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
                                    window.location.replace("/member/investment/investment_plan");
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
                $('#edit_plan-'+investment_id).on('hidden.bs.modal', function () {
                    form.find('span.error-text').text('');
                    form.find('.error').removeClass('border-danger');
                });
            });
        });
    </script>
@endsection


