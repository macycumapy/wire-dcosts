<div class="max-w-7xl sm:mx-auto sm:px-6 lg:px-8 sm:my-12 m-2">
    <x-card card-classes="h-full">
        <div class="min-w-full">
            <div class="flex justify-end py-2">
                @livewire('account-cash-transfer.account-cash-transfer-modal')
            </div>

            <div class="divide-y divide-gray-500">
                <div class="grid grid-cols-4 p-4 sm:px-4 sm:py-2 font-semibold gap-x-4 sticky top-0 bg-gray-800">
                    <div>Со счета</div>
                    <div>Сумма</div>
                    <div>На счет</div>
                    <div></div>
                </div>
                <div id="list" class="divide-y divide-gray-500 h-[65vh] sm:h-[71vh] 2k:h-[77vh] overflow-auto soft-scrollbar">
                    @forelse($items as $key => $transfer)
                        <div wire:key="row_{{ $transfer->id }}">
                            <div class="p-4 grid grid-cols-4 gap-4">
                                <div class="my-auto truncate">{{ $transfer->fromAccount->name }}</div>
                                <div class="my-auto">{{ number_format($transfer->sum, 2, '.', ' ') }}</div>
                                <div class="my-auto truncate">{{ $transfer->toAccount->name }}</div>
                                <div class="my-auto col-span-3 sm:col-span-1 flex sm:justify-end justify-between">
                                    @livewire('account-cash-transfer.account-cash-transfer-delete-button', [
                                        'cashTransfer' => $transfer
                                    ], key($transfer->id))
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6">
                            Список пуст
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </x-card>
</div>
