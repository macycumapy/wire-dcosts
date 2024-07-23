<div class="max-w-7xl sm:mx-auto sm:p-4 p-2">
    <x-card card-classes="h-full" padding="sm:p-4 p-2">
        <div class="min-w-full">
            <div class="flex justify-end py-2">
                @livewire('account-cash-transfer.account-cash-transfer-modal')
            </div>

            <div class="divide-y divide-gray-500">
                <div class="grid grid-cols-3 sm:grid-cols-4 p-2 sm:p-4 font-semibold gap-x-4 sticky top-24 sm:top-28 shadow-md bg-secondary-800 text-xs sm:text-base">
                    <div>Со счета</div>
                    <div class="text-center sm:text-left">Сумма</div>
                    <div class="text-right sm:text-left">На счет</div>
                </div>
                <div id="list" class="divide-y divide-gray-500 min-h-[60vh]">
                    @forelse($items as $key => $transfer)
                        <div wire:key="row_{{ $transfer->id }}">
                            <div class="p-4 grid grid-cols-3 sm:grid-cols-4 gap-4">
                                <div class="my-auto truncate">{{ $transfer->fromAccount->name }}</div>
                                <div class="my-auto">{{ number_format($transfer->sum, 2, '.', ' ') }}</div>
                                <div class="my-auto truncate">{{ $transfer->toAccount->name }}</div>
                                <div class="my-auto col-span-3 sm:col-span-1 flex justify-end">
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
