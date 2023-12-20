<div
    data-te-modal-init
    class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
    id="eventModal-{{ $event->id }}"
    tabindex="-1"
    aria-labelledby="eventModal-{{ $event->id }}_label"
    aria-hidden="true">
    <div
        data-te-modal-dialog-ref
        class="pointer-events-none relative h-[calc(100%-1rem)] w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
        <div
            class="pointer-events-auto relative flex max-h-[100%] w-full flex-col overflow-hidden rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
            <div
                class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                <h5
                    class="text-xl font-medium leading-normal text-blue-400 dark:text-neutral-200"
                    id="eventModal-{{ $event->id }}_label">
                    {{ $event->event_title }}
                </h5>
                <button
                    type="button"
                    class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                    data-te-modal-dismiss
                    aria-label="Close">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-6 w-6 text-gray-300">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="relative overflow-y-auto mx-auto p-4">
                @if($event->hasMedia('event_images'))
                    @foreach($event->getMedia('event_images') as $event_img)
                        <img src="{{ $event_img->getUrl() }}" class="object-cover my-6" alt="">
                    @endforeach
                @endif
            </div>
            <div
                class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                <button
                    type="button"
                    class="inline-block rounded bg-blue-100 px-6 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-blue-700 transition duration-150 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200"
                    data-te-modal-dismiss
                    data-te-ripple-init
                    data-te-ripple-color="light">
                    @lang('public.close')
                </button>
            </div>
        </div>
    </div>
</div>
