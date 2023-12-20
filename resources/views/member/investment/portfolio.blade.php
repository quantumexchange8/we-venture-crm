@extends('layouts.master-member')

@section('title') Portfolio List @endsection

@section('contents')

    <nav class="flex " aria-label="Breadcrumb">
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
                        @lang('public.portfolio')</p>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-6">
        @foreach($portfolios as $portfolio)
            <div class="w-full p-4 bg-blue-100 border-2 border-blue-400 rounded-lg shadow-lg sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400">{{ $portfolio->name }}</h5>
                <div class="flex items-baseline text-gray-900 dark:text-white">
                    <span class="text-3xl font-semibold">$</span>
                    <span class="text-5xl font-extrabold tracking-tight">{{ number_format($portfolio->min_amount, '2') }}</span>
                </div>
                <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">@lang('public.min_amount')</p>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{!! $portfolio->description !!}</p>
                <a href="javascript:void(0)" class="mt-6 text-white bg-blue-400 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center choose_button" data-te-toggle="modal"
                   data-te-target="#investmentPlan-{{ $portfolio->id }}"
                   data-te-ripple-init
                   data-te-ripple-color="light"
                   data-portfolio-id="{{ $portfolio->id }}">
                    Choose Plan
                </a>
                @include('member.investment.investment_modal')
            </div>
        @endforeach
    </div>

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.choose_button').on('click', function() {
                var portfolioId = $(this).data('portfolio-id');
                var form = $('#choose_plan_'+portfolioId);

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
                $('#investmentPlan-'+portfolioId).on('hidden.bs.modal', function () {
                    form.find('span.error-text').text('');
                    form.find('.error').removeClass('border-danger');
                });
            });
        });
    </script>
@endsection
