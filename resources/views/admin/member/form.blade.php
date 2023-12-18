@extends('layouts.master-admin')

@section('title') Member {{ $title }} @endsection

@section('contents')

    <div class="flex flex-row">
        @if($title == 'Add')
            <h1 class="flex-1 font-semibold text-2xl text-gray-500">@lang('public.members') / {{ $title == 'Add' ? trans('public.add_member') : trans('public.update_member') }}</h1>
            <a href="{{ route('member_listing') }}" class=" font-semibold text-md text-gray-500 rounded-lg px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-500 dark:hover:bg-[#050708]/30 mr-2 mb-2">
                <svg class="h-4 w-4 text-white"  fill="none" viewBox="0 0 24 24" stroke="#fb923c">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                </svg>
                <span class="ml-4 text-xl text-orange-400">@lang('public.cancel')</span>
            </a>
        @elseif($title == 'Edit')
            <h1 class="flex-1 font-semibold text-2xl text-gray-500">@lang('public.members')  / {{ @$user->name }} - @lang('public.member_edit')</h1>
            <a href="{{ route('member_details', @$user->id) }}" class=" font-semibold text-md text-gray-500 rounded-lg px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-500 dark:hover:bg-[#050708]/30 mr-2 mb-2">
                <svg class="h-4 w-4 text-white"  fill="none" viewBox="0 0 24 24" stroke="#fb923c">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                </svg>
                <span class="ml-4 text-xl text-orange-400">@lang('public.cancel')</span>
            </a>
        @endif
    </div>

    <form method="post" action="{{ $submit }}" enctype="multipart/form-data">
        @csrf
        <div class="bg-[#FDFCF3] shadow-lg p-8">
            <h3 class="text-gray-500 font-bold text-lg mb-4">@lang('public.member_access')</h3>
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="email" class="block mb-2 font-semibold text-sm text-orange-400 dark:text-white">@lang('public.email_address')</label>
                    <input type="email" id="email" name="email" class="font-medium text-sm placeholder:text-gray-400 text-gray-500 bg-gray-50 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500 @error('email') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="email@company.com" value="{{ @$post->email }}">
                    @error('email')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="rank" class="block mb-2 font-semibold text-sm text-orange-400 dark:text-white">@lang('public.role')</label>
                    {!! Form::select('role', $get_role_sel, @$post->role, ['class' => 'font-medium text-sm text-gray-500 bg-gray-50 border border-gray-300 text-sm placeholder:text-gray-400 text-gray-500 rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500']) !!}
                </div>
                <div>
                    <label for="password" class="flex block mb-2 text-sm font-semibold text-orange-400">
                        @lang('public.password') <button data-popover-target="popover-description" data-popover-placement="bottom-start" type="button"><svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only"></span></button>
                        <div data-popover id="popover-description" role="tooltip" class="absolute z-10 invisible inline-block text-sm font-light text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                            <div class="p-3 space-y-2">
                                <h3 class="font-semibold text-gray-900 dark:text-white">@lang('public.password_type')</h3>
                                <p>@lang('public.password_validation_2')</p>
                                <p>@lang('public.password_validation_4')</p>
                            </div>
                            <div data-popper-arrow></div>
                        </div>
                    </label>
                    <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 placeholder:text-gray-400 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500 @error('password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.password')" value="{{ @$post->password }}">
                    @error('password')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="confirm_password" class="block mb-2 font-semibold text-sm text-orange-400 dark:text-whit">@lang('public.password_confirmation')</label>
                    <input type="password" id="confirm_password" name="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 placeholder:text-gray-400 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500 @error('password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.password_confirmation')" value="{{ @$post->confirm_password ?? @$post->password }}">
                </div>
            </div>
        </div>
        <div class="bg-[#FDFCF3] shadow-lg p-8 mt-6">
            <h3 class="text-gray-500 font-bold text-lg mb-4">@lang('public.member_details')</h3>
            @if($title == 'Edit')
                <div class="flex flex-col items-center p-8">
                    <div class="relative inline-flex items-center justify-center w-20 h-20 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600">
                        @if (@$user->profile_image)
                            <img src="{{ asset('uploads/users/' .@$user->profile_image)}}" id="profile_pic_preview" class="relative inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                        @else
                            <img src="{{url('/img/profile.png')}}" id="profile_pic_preview" class="relative inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                        @endif
                    </div>
                    <div class="mt-4">
                        <label class="font-semibold text-sm text-gray-500 block mb-2 text-gray-900 dark:text-white" for="file_input">@lang('public.upload_file')</label>
                        <input class="font-medium text-sm text-gray-500 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 file" name="profile_image" id="file_input" type="file" accept="image/png, image/gif, image/jpeg">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">@lang('public.profile_pic_req')</p>
                    </div>
                </div>
            @endif
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="name" class="block mb-2 font-semibold text-sm text-orange-400 dark:text-white">@lang('public.name')</label>
                    <input type="text" id="name" name="name" class="font-medium text-sm placeholder:text-gray-400 text-gray-500 bg-gray-50 border border-gray-300  rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500 @error('name') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.name')" value="{{ @$post->name }}">
                    @error('name')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="address" class="block mb-2 font-semibold text-sm text-orange-400 dark:text-white">@lang('public.address')</label>
                    <input type="text" id="address" name="address" class="font-medium text-sm placeholder:text-gray-400 text-gray-500 bg-gray-50 border border-gray-300  rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500 @error('address') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.address')" value="{{ @$post->address }}">
                    @error('address')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="rank" class="block mb-2 font-semibold text-sm text-orange-400 dark:text-white">@lang('public.rank')</label>
                    {!! Form::select('rankId', $get_rank_sel, @$post->rankId, ['class' => 'font-medium text-sm text-gray-500 bg-gray-50 border border-gray-300 text-sm placeholder:text-gray-400 text-gray-500 rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500']) !!}
                </div>
                <div>
                    <label for="contact_number" class="block mb-2 font-semibold text-sm text-orange-400 dark:text-white">@lang('public.contact')</label>
                    <input type="text" id="contact_number" name="contact_number" class="font-medium text-sm text-gray-500 bg-gray-50 border border-gray-300 text-sm placeholder:text-gray-400 text-gray-500 rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500 @error('contact_number') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="Ex. +6012..." value="{{ @$post->contact_number }}">
                    @error('contact_number')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="countries" class="block mb-2 text-sm font-semibold text-orange-400 dark:text-white">@lang('public.country')</label>
                    {!! Form::select('country', $get_country_sel, @$post->country, ['class' => 'font-medium text-sm placeholder:text-gray-400 text-gray-500 bg-gray-50 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500']) !!}
                </div>
                <div>
                    <label for="status" class="block mb-2 font-semibold text-sm text-orange-400 dark:text-white">@lang('public.status')</label>
                    {!! Form::select('status', $get_status_sel, @$post->status, ['class' => 'font-medium text-sm placeholder:text-gray-400 text-gray-500 bg-gray-50 border border-gray-300 text-sm text-gray-500 rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500']) !!}
                </div>
                <div>
                    <label for="leader_status" class="block mb-2 font-semibold text-sm text-orange-400 dark:text-white">@lang('public.leader_status')</label>
                    {!! Form::select('leader_status', $get_leader_status_sel, @$post->leader_status, ['class' => 'font-medium text-sm placeholder:text-gray-400 text-gray-500 bg-gray-50 border border-gray-300 text-sm text-gray-500 rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500']) !!}
                </div>
            </div>
            @if($title == 'Add')
                <button type="submit" class="text-white bg-[#40DD7F] hover:bg-success-800 focus:ring-4 focus:outline-none focus:ring-success-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-success-600 dark:hover:bg-success-700 dark:focus:ring-success-800">@lang('public.member_add')</button>
            @else
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">@lang('public.update')</button>
            @endif

        </div>
    </form>

@endsection
@section('script')

    <script>
        let imageUpload = document.getElementById("file_input");
        // display file name if file has been selected
        imageUpload.onchange = function() {
            let input = this.files[0];
            let image = document.getElementById('profile_pic_preview');
            if (input) {
                image.src =URL.createObjectURL(input);
            } else {
                image.src = '/img/profile.png';
            }
        };
    </script>
@endsection
