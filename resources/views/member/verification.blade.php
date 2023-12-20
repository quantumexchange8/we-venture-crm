<!-- @extends('layouts.master-member')

@section('title')
    Profile
@endsection

@section('contents')
    <nav class="flex " aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 text-lg font-semibold">
            <li class="inline-flex items-center">
                <a href="javascript:void(0)"
                   class="inline-flex items-center text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                         class="w-7 h-7 mr-4">
                        <path fill-rule="evenodd"
                              d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                              clip-rule="evenodd"/>
                    </svg>
                    @lang('public.profile')
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                              clip-rule="evenodd"></path>
                    </svg>
                    <a href="javascript:void(0)"
                       class="ml-1  text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">@lang('public.profile_verification')</a>
                </div>
            </li>
            @if(auth()->user()->kyc_approval_status == App\Models\User::KYC_STATUS_PENDING_VERIFICATION)
                <span class="bg-success-100 text-success-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-success-900 dark:text-success-300">@lang('public.kyc_pending_message')</span>
            @elseif(auth()->user()->kyc_approval_status == App\Models\User::KYC_STATUS_NOT_VERIFY)
                <span class="bg-warning-100 text-warning-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-warning-900 dark:text-warning-300">@lang('public.kyc_not_verify_message')</span>
            @elseif(auth()->user()->kyc_approval_status == App\Models\User::KYC_STATUS_REJECTED)
                <span class="bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">@lang('public.kyc_reject_message')</span>
            @endif
        </ol>
    </nav>

    <div
        class="w-full h-auto p-4 text-center border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 mt-4 bg-blue-100">
        <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
            @lang('public.member_verification_message')
        </p>

        <form class="space-y-6" action="{{ route('member_verification') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <p class="block mb-2 font-bold text-2xl text-[#3F83F8]">@lang('public.front_id')</p>
                    @if($user->front_id_image)
                        <div class="flex justify-center item-center">
                            <img
                                class="object-cover w-full rounded-lg h-96 md:h-auto md:w-64 md:rounded-none md:rounded-lg mb-4"
                                src="{{ asset('uploads/users/'.$user->front_id_image)}}" alt="">
                        </div>
                    @endif
                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-front" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6" id="content-front">
                                <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">@lang('public.click_upload')</span> @lang('public.or_drap_drop')</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">@lang('public.id_req')</p>
                            </div>
                            <input id="dropzone-front" type="file" name="front_id_image" class="hidden" onchange="onchangeFrontUpload()"/>
                        </label>
                    </div>
                </div>
                <div>
                    <p class="block mb-2 font-bold text-2xl text-[#3F83F8]">@lang('public.back_id')</p>
                    @if($user->back_id_image)
                        <div class="flex justify-center item-center">
                            <img
                                class="object-cover w-full rounded-lg h-96 md:h-auto md:w-64 md:rounded-none md:rounded-lg mb-4"
                                src="{{ asset('uploads/users/' .$user->back_id_image)}}" alt="">
                        </div>
                    @endif
                    <div class="flex items-center justify-center w-full">
                        <label for="dropzone-back" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6" id="content-back">
                                <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">@lang('public.click_upload')</span> @lang('public.or_drap_drop')</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">@lang('public.id_req')</p>
                            </div>
                            <input id="dropzone-back" type="file" name="back_id_image" class="hidden" onchange="onchangeBackUpload()"/>
                        </label>
                    </div>
                </div>
            </div>

            <button type="submit"
                    class="text-white bg-[#40DD7F] hover:bg-[#40DD7F]/90 focus:ring-4 focus:outline-none focus:ring-[#40DD7F]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#40DD7F]/55 ">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="ml-2">
                @lang('public.upload_id')
            </span>
            </button>
        </form>
    </div>

@endsection

@section('script')

    <script>
        function onchangeFrontUpload(){
            document.getElementById("content-front").innerHTML =
                `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" />
</svg>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">@lang('public.file_uploaded')</p>
                `
        }

        function onchangeBackUpload(){
            document.getElementById("content-back").innerHTML =
                `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" />
</svg>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">@lang('public.file_uploaded')</p>
                `
        }


    </script>
@endsection -->
