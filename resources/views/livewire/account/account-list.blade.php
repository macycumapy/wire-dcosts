<div class="max-w-7xl sm:mx-auto sm:p-4 p-2">
    <x-card card-classes="h-full" padding="sm:p-4 p-2">
        <div class="min-w-full">
            <div class="flex justify-end py-2">
                <livewire:account.account-modal></livewire:account.account-modal>
            </div>

            <div class="divide-y divide-primary-600 dark:divide-secondary-500">
                <div class="grid grid-cols-3 sm:grid-cols-4 p-2 sm:p-4 font-semibold gap-x-4 sticky top-24 sm:top-28 shadow-[0_10px_10px_-15px_rgba(0,0,0,0.3)] dark:shadow-md bg-white dark:bg-secondary-800 text-xs sm:text-base">
                    <div>Название</div>
                    <div class="text-center sm:text-left">Баланс</div>
                    <div class="text-right sm:text-left">Коммент</div>
                </div>
                <div id="list" class="divide-y divide-primary-600 dark:divide-secondary-500 min-h-[60vh]">
                    @forelse($items as $key => $account)
                        <div wire:key="row_{{ $account->id }}">
                            <div class="p-4 grid grid-cols-3 sm:grid-cols-4 gap-4">
                                <div class="my-auto truncate">{{ $account->name }}</div>
                                <div class="my-auto text-sm">{{ number_format($account->balance, 2, '.', ' ') }}</div>
                                <div class="my-auto truncate">{{ $account->comment }}</div>
                                <div class="my-auto col-span-3 sm:col-span-1 flex justify-end">
                                    <livewire:account.account-modal
                                        :id="$account->id"
                                        :key="$account->id"
                                    ></livewire:account.account-modal>
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
