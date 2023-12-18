@extends('layouts.master-admin')

@section('title') News @endsection

@section('contents')
    <h1 class="font-semibold text-2xl text-gray-500">@lang('public.setting') / @lang('public.setting_listing')</h1>

    @if($settings->isNotEmpty())
            <?php
            $no = $settings->firstItem();
            ?>
        <div class="relative overflow-x-auto mt-2 text-sm mt-4">
            <table class="w-full text-black text-left dark:text-gray-400 table-auto">
                <thead class="uppercase bg-[#F6F6F6]">
                <tr>
                    <th class="px-6 py-3 text-md font-bold" style="width: 8%">
                        #
                    </th>
                    <th  class="px-6 py-3 text-md font-bold">
                        @lang('public.title')
                    </th>
                    <th  class="px-6 py-3 text-md font-bold" style="width: 12%">
                        @lang('public.value')
                    </th>
                    <th  class="px-6 py-3 text-md font-bold w-12 text-center" style="width: 8%">
                        @lang('public.action')
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($settings as $setting)
                    <tr class="border-b odd:bg-[#FDFCF3] even:bg-[#F6F6F6]">
                        <td class="px-6 py-4 ">
                            {{ $no }}
                        </td>
                        <td class="px-6 py-4">
                            {{ ucfirst(str_replace('_', ' ', $setting->name)) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $setting->value }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('setting_edit', $setting->id) }}" class="flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 fill-primary hover:fill-primary-400">
                                    <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                        <?php
                        $no++;
                        ?>
                @endforeach
                </tbody>
            </table>
            <div class="my-4">
                {!! $settings->links('pagination::tailwind') !!}
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
