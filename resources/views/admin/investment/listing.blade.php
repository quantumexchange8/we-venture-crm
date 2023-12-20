@extends('layouts.master-admin')

@section('title') {{ $title }} @endsection

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
    <h1 class="font-semibold text-2xl text-gray-500">@lang('public.investment') / @lang('public.listing') </h1>

    <!-- component -->
    <div class="flex flex-col">
        <form method="post" action="{{ route('investment_listing') }}">
            @csrf
            <div class="grid gap-6 mb-6 mt-4 grid-cols-2 max-[1300px]:grid-cols-1 max-[1000px]:grid-cols-1 max-[770px]:grid-cols-1">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" id="search" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="@lang('public.search_email')" name="freetext" value="{{ @$search['freetext'] }}">
                </div>
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
                <div>
                    {!! Form::select('filter_status', $get_status_sel, @$search['status'], ['class' => 'bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500', 'placeholder' => trans('public.select_status')]) !!}
                </div>
                <div>
                    <button type="submit" class="text-white bg-primary hover:bg-primary-600 border border-primary-200 focus:ring-4 focus:outline-none focus:ring-primary-600 font-medium rounded-lg text-sm max-[770px]:w-full w-auto mb-2 px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" name="submit" value="search">@lang('public.search')</button>
                    <button type="submit" class="text-white bg-rose-500 hover:bg-rose-600 border border-rose-200 focus:ring-4 focus:outline-none focus:ring-rose-600 font-medium rounded-lg text-sm max-[770px]:w-full w-auto mb-2 px-5 py-2.5 text-center dark:bg-rose-600 dark:hover:bg-rose-700 dark:focus:ring-red-800" name="submit" value="reset">@lang('public.reset')</button>
                    <button type="submit" name="submit" value="export" class="text-md justify-center text-center text-white py-2 px-6 rounded bg-[#3F83F8] hover:bg-blue-400 font-bold float-right flex items-center max-[770px]:w-full max-[760px]:mt-2">
                        <svg class="h-6 w-6 text-white mr-2"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />  <polyline points="17 8 12 3 7 8" />  <line x1="12" y1="3" x2="12" y2="15" /></svg>
                        @lang('public.export_report')
                    </button>
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
                <thead class="uppercase bg-blue-100 text-sm">
                <tr>
                    <th scope="col" class="p-4 text-center">
                        #
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
                            @lang('public.portfolio')
                        </div>
                    </th>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            @lang('public.min_amount')
                        </div>
                    </th>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            @sortablelink('deposit_amount',  trans('public.deposit_amount'))
                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            @sortablelink('created_at', trans('public.date'))
                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            @sortablelink('status', trans('public.status'))
                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($records as $record)
                    <tr class="border-b odd:bg-[#FFFFFF] even:bg-blue-100 text-sm">
                        <th scope="row" class="p-4 font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $no }}
                        </th>
                        <td class="p-4">
                            @if($record->status === 'processing')
                                <a href="#investment_plan-{{ $record->id }}" class="underline text-[#1A8BFF]"
                                   data-modal-target="investment_plan-{{ $record->id }}" data-modal-toggle="investment_plan-{{ $record->id }}"
                                   data-te-ripple-init
                                   data-te-ripple-color="light">
                                    {{ $record->user->name }}
                                </a>
                            @else
                                {{ $record->user->name }}
                            @endif
                            @include('admin.investment.modal')
                        </td>
                        <td class="p-4">
                            {{ $record->user->email }}
                        </td>
                        <td class="p-4">
                            {{ $record->portfolio->name }}
                        </td>
                        <td class="p-4">
                            $ {{ $record->portfolio->min_amount }}
                        </td>
                        <td class="p-4">
                            $ {{ $record->deposit_amount }} <br>
                            <a data-modal-target="receipt-modal-{{ $record->id }}" data-modal-toggle="receipt-modal-{{ $record->id }}" class="text-blue-500 hover:text-blue-600" href="javascript:void(0);">@lang('public.click_to_view')</a>

                            <div id="receipt-modal-{{ $record->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative w-full max-w-2xl max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-blue-400 dark:text-white">
                                                @lang('public.deposit_receipt')
                                            </h3>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="receipt-modal-{{ $record->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-6 space-y-6">
                                            @if($record->hasMedia('deposit_receipt'))
                                                @if($record->getMedia('deposit_receipt')[0]->mime_type == 'application/pdf')
                                                    <iframe class="h-96 mx-auto max-w-full" src="{{ $record->getFirstMediaUrl('deposit_receipt') }}"></iframe>
                                                @elseif($record->getMedia('deposit_receipt')[0]->mime_type == 'image/png' || $record->getMedia('deposit_receipt')[0]->mime_type == 'image/jpg')
                                                    <img class="h-auto max-w-full" src="{{ $record->getFirstMediaUrl('deposit_receipt') }}" alt="image description">
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                        <td class="p-4">
                            {{ date_format($record->created_at, 'Y-m-d') }}
                        </td>
                        <td class="p-4">
                            @if($record->status == 'processing')
                                <span class="text-primary font-semibold uppercase">@lang('public.' . $record->status)</span>
                            @elseif($record->status == 'approved')
                                <span class="text-success font-semibold uppercase">@lang('public.' . $record->status)</span>
                            @elseif($record->status == 'rejected')
                                <span class="text-danger font-semibold uppercase">@lang('public.' . $record->status)</span>
                            @endif
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
                {!! $records->links('pagination::tailwind') !!}
            </div>
        </div>
    @else
        <div class="flex p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-300" role="alert">
            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">@lang('public.info')</span>
            <div>
                <span class="font-medium">@lang('public.info') :</span>@lang('public.no_record')
            </div>
        </div>
    @endif

    <!-- Import Modal -->
    <div id="importModal" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto">
            <!-- Modal content -->

            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-md p-4 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-hide="importModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">@lang('public.close_modal')</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <form method="post" action="{{ route('import_withdrawal') }}" enctype="multipart/form-data">@csrf
                        <h3 class="mb-4 text-xl font-semibold inline-block text-blue-500 dark:text-white">@lang('public.import_withdrawals')</h3>
                        <span class="pl-2 inline-flex pt-2 text-black text-lg font-bold">
                            <button type="submit" name="submit" value="download" class="text-xs text-blue-600 dark:text-blue-500 underline ">@lang('public.download_template')</button>
                    </span>
                        <div class="mb-4 mt-4">

                            <div class="flex items-center mb-4 justify-center w-full">
                                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <div id="content" class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">@lang('public.click_upload')</span> @lang('public.or_drap_drop')</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">@lang('public.excel_mime_type')</p>
                                    </div>
                                    <input id="dropzone-file" name="file" type="file"  accept=".xlsx, .csv, .xls" class="hidden" onchange="onchangeFileUpload()"/>
                                </label>
                            </div>

                        </div>
                        <div class="flex items-center  mb-4 justify-center w-full">
                            <button type="submit" class="text-white bg-blue-400 hover:bg-blue-600 border border-blue-200 focus:ring-4 focus:outline-none focus:ring-blue-400 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" name="submit" value="import">Import</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
        function onchangeFileUpload(){
            document.getElementById("content").innerHTML =
                `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" />
</svg>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">@lang('public.file_uploaded')</p>
                `
        }

        $(document).ready(function(e) {
            $('.delete').on('click', function() {
                var id = $(this).attr('id');
                $(".modal-body #deposit_id").val( id );
            });
        });

    </script>
@endsection
