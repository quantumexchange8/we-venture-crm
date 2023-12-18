<!-- Approval Modal -->
<div id="profile_approval_modal-{{ $record->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
    <div class="relative w-full h-full max-w-4xl md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="profile_approval_modal-{{ $record->id }}">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">@lang('public.close_modal')</span>
            </button>
            <div class="px-6 py-6 lg:px-8">
                <form method="post" action="{{ route('member_profile_approval', $record->id) }}">
                    @csrf
                    <div class="w-full">
                        <div class="flex flex-col h-full">
                            <!-- Card top -->
                            <div class="flex-grow p-5">
                                <div class="flex justify-between items-start">
                                    <!-- Image + name -->
                                    <header>
                                        <div class="flex mb-2">
                                            <a class="relative inline-flex items-start mr-5" target="_blank" href="{{ route('member_details', @$record->user->id) }}">
                                                <div class="relative inline-flex items-center justify-center w-20 h-20 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600">
                                                    @if (@$record->user->profile_image)
                                                        <img src="{{ asset('uploads/users/' .@$record->user->profile_image)}}" id="profile_pic_preview" class="relative inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                                                    @else
                                                        <img src="{{url('/img/profile.png')}}" id="profile_pic_preview" class="relative inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                                                    @endif
                                                </div>
                                                <div class="mt-4 ml-2 pr-1">
                                                    <div class="inline-flex text-gray-800 hover:text-gray-900">
                                                        <h2 class="text-xl leading-snug justify-center font-semibold">{{ $record->user->name }}</h2>
                                                    </div>
                                                    <p class="font-medium text-gray-500 dark:text-gray-400 ">{{ $record->user->email }}</p>
                                                </div>
                                            </a>
                                        </div>
                                    </header>
                                </div>
                                <!-- Description -->
                                <div class="mt-2 mb-4">
                                    <p class="text-lg text-gray-500 dark:text-gray-400 "><b>@lang('public.edited_detail')</b></p>
                                </div>
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <p class="font-medium text-gray-500 dark:text-gray-400 "> @lang('public.name'):</p>
                                        <p>{{ $record->name }}</p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="font-medium text-gray-500 dark:text-gray-400 "> @lang('public.country'):</p>
                                        <p>{{ $record->country }}</p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="font-medium text-gray-500 dark:text-gray-400 "> @lang('public.contact'):</p>
                                        <p>{{ $record->contact_number }}</p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="font-medium text-gray-500 dark:text-gray-400 "> @lang('public.address'):</p>
                                        <p>{{ $record->address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="text-white bg-[#40DD7F] hover:bg-green-400 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" value="approve" name="status">
                            <svg class="h-6 w-6 text-white"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r="9" />  <path d="M9 12l2 2l4 -4" /></svg>
                            <span class="ml-2">@lang('public.approve')</span>
                        </button>
                        <button type="submit" class="text-white bg-[#FF6262] hover:bg-red-400 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" value="reject" name="status">
                            <svg class="h-6 w-6 text-white"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="15" y1="9" x2="9" y2="15" />  <line x1="9" y1="9" x2="15" y2="15" /></svg>
                            <span class="ml-2">@lang('public.reject')</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
