@extends('layouts.master-admin')

@section('title') Profile {{ $title }} @endsection

@section('contents')

    <div class="flex flex-row">
        <h1 class="flex-1 font-semibold text-2xl text-gray-500"> @lang('public.profile') / @lang('public.edit') </h1>
        <a href="{{ route('admin_dashboard') }}" class="text-xl font-semibold text-[#3F83F8]">@lang('public.back')</a>
    </div>

    <div class="flex justify-center mt-8">
        <form method="post" action="{{ $submit }}" enctype="multipart/form-data">
            @csrf
            <div class="flex items-start rounded-xl bg-blue-100 shadow-lg">
                <div class="ml-4 px-12 pb-8 md:mt-6">
                    <div class="flex flex-col items-center p-8">
                        <div class="relative inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-blue-500 rounded-full dark:bg-gray-600">
                            @if ($user->profile_image)
                                <img src="{{ asset('uploads/users/' .$user->profile_image)}}" id="profile_pic_preview" class="relative inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-blue-500 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl">
                            @else
                                <img src="{{url('/img/profile.png')}}" id="profile_pic_preview" class="object-contain relative inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-blue-500 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl">
                            @endif
                        </div>
                        <div class="mt-4">
                            <label class="font-semibold text-md text-gray-500 block mb-2 text-gray-900 dark:text-white" for="file_input">@lang('public.upload_file')</label>
                            <input class="font-semibold text-md text-gray-500 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" name="profile_image" id="file_input" type="file" accept="image/png, image/gif, image/jpeg">
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="name" class="block mb-2 font-semibold text-md text-blue-500 dark:text-white">@lang('public.name')</label>
                        <input type="text" id="name" name="name" class="font-semibold placeholder:text-gray-400 text-md text-gray-500 bg-gray-50 border border-gray-300  rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('name') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.name')" value="{{ $post->name }}">
                        @error('name')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <div>
                            <label for="email" class="block mb-2 font-semibold text-md text-blue-500 dark:text-white">@lang('public.email_address')</label>
                            <input type="email" id="email" name="email" class="font-semibold placeholder:text-gray-400 text-md text-gray-500 bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('email') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="email@company.com" value="{{ $post->email }}">
                            @error('email')
                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="contact_number" class="block mb-2 font-semibold text-md text-blue-500 dark:text-white">@lang('public.contact')</label>
                        <input type="text" id="contact_number" name="contact_number" class="font-semibold placeholder:text-gray-400 text-md text-gray-500 bg-gray-50 border border-gray-300 font-semibold text-md text-gray-500 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('contact_number') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="Ex. +6012..." value="{{$post->contact_number }}">
                        @error('contact_number')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <div>
                            <label for="countries" class="block mb-2 font-semibold text-blue-500 dark:text-white">@lang('public.country')</label>
                            {!! Form::select('country', $get_country_sel, $post->country, ['class' => 'font-semibold text-md text-gray-500 bg-gray-50 border border-gray-300 placeholder:text-gray-400 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']) !!}
                        </div>
                    </div>
                    <button type="submit" class="text-white rounded-lg bg-[#1A8BFF] hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-700 font-semibold text-mdrounded-lg px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-blue-500 dark:hover:bg-[#050708]/30 float-right">@lang('public.update')</button>
                </div>
            </div>
        </form>
    </div>

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

