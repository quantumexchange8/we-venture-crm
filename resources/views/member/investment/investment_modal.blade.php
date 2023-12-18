<div
    data-te-modal-init
    class="fixed top-0 left-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
    id="investmentPlan-{{ $portfolio->id }}"
    tabindex="-1"
    aria-labelledby="investmentPlan-{{ $portfolio->id }}_label"
    aria-hidden="true">
    <div
        data-te-modal-dialog-ref
        class="pointer-events-none relative h-[calc(100%-1rem)] w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
        <div
            class="pointer-events-auto relative flex max-h-[100%] w-full flex-col overflow-y-auto rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
            <div
                class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">
                <h5
                    class="text-xl font-medium leading-normal text-orange-400 dark:text-neutral-200"
                    id="investmentPlan-{{ $portfolio->id }}_label">
                    {{ $portfolio->name }}
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
            <form action="{{ route('investment.choose_plan') }}" method="POST" enctype="multipart/form-data" id="choose_plan_{{ $portfolio->id }}" class="p-6">
                @csrf
                <input type="hidden" name="portfolio_id" value="{{ $portfolio->id }}">
                <div class="mb-4">
                    <label for="balance"
                           class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">@lang('public.min_amount') (USD)
                    </label>
                    <input type="text" name="balance" id="balance" aria-label="disabled input 1" disabled
                           readonly value="{{number_format($portfolio->min_amount, 2)}}"
                           class="bg-gray-50 border border-gray-300 text-orange-500 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white balance"
                           required>
                    <span class="text-danger text-xs error-text balance_error"></span>
                </div>
                <div class="mb-4 flex justify-center">
                    {{ QrCode::size(150)->generate($wallet_address) }}
                </div>
                <div class="flex justify-center gap-2">
                    <input type="text" class="border-0 bg-white" id="wallAdd" value="{{ $wallet_address }}" disabled>
                    <button type="button" id="copyAdd">
                        <svg class="h-6 w-6 text-gray-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <rect x="8" y="8" width="12" height="12" rx="2" />  <path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /></svg>
                    </button>
                </div>
                <div class="mb-4">
                    <label for="deposit_amount"
                           class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">@lang('public.deposit_amount')
                    </label>
                    <input type="number" name="amount" id="deposit_amount"
                           step="0.01"
                           class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500 amount"
                    >
                    <span class="text-danger text-xs error-text amount_error"></span>
                </div>
                <div class="mb-4">
                    <label for="deposit_receipt" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">@lang('public.deposit_receipt')</label>
                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="deposit_receipt" type="file" name="deposit_receipt" accept="image/*,.pdf">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PDF, PNG, JPG (MAX. 5MB).</p>

                    <span class="text-danger text-xs error-text deposit_receipt_error"></span>
                </div>
                <button type="submit" id="total-edit"
                        class="w-full text-white bg-success hover:ring-success  focus:ring-4 focus:outline-none focus:ring-success font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    @lang('public.submit')
                </button>
            </form>
        </div>
    </div>
</div>
