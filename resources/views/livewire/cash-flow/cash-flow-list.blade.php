<div>
    <div x-data="{
            isLoading: @entangle('isLoading'),
            itemsCount: @entangle('itemsCount'),
            perPage: @entangle('perPage')
        }" x-init="
        let list = document.getElementById('list');
        let listRect = list.getBoundingClientRect();

        list.onscroll = function () {
            if (list.scrollTop + listRect.bottom * 1.1 > list.scrollHeight && !isLoading && itemsCount > perPage) {
                isLoading = true;
                $wire.loadMore()
            }
        }
    " class="min-w-full divide-y divide-gray-500">
        <div class="grid grid-cols-3 sm:grid-cols-4 p-4 font-semibold gap-4 sticky top-0 bg-gray-800">
            <div>Дата</div>
            <div>Сумма</div>
            <div>Категория</div>
            <div></div>
        </div>
        <div id="list" class="divide-y divide-gray-500 h-[60vh] sm:h-[65vh] overflow-auto soft-scrollbar">
            @forelse($items as $key => $cashFlow)
                <div wire:key="row_{{ $cashFlow->id }}">
                    <div class="p-4 grid grid-cols-3 sm:grid-cols-4 gap-4">
                        <div>
                            {{ $cashFlow->date->timezone($timezone)->isToday() ? 'Сегодня' : $cashFlow->date->timezone($timezone)->format('d.m.Y') }}
                        </div>
                        <div class="text-{{ $cashFlow->type->color() }}-600 text-center sm:text-left">
                            {{ number_format($cashFlow->sum, 2, '.', ' ') }}
                        </div>
                        <div class="truncate">
                            {{ $cashFlow->category?->name }}
                        </div>
                        <div class="col-span-3 sm:col-span-1 flex sm:justify-end justify-between">
                            @if($cashFlow->type === \App\Enums\CashFlowType::Inflow)
                                <x-button.circle
                                    flat
                                    wire:navigate
                                    href="{{ route('inflows.edit', ['id' => $cashFlow->id, 'clone' => true]) }}"
                                    icon="document-duplicate"
                                ></x-button.circle>
                                <x-button.circle
                                    flat
                                    wire:navigate
                                    href="{{ route('inflows.edit', ['id' => $cashFlow->id]) }}"
                                    icon="pencil-alt"
                                ></x-button.circle>
                            @else
                                <x-button.circle
                                    flat
                                    wire:navigate
                                    href="{{ route('outflows.edit', ['id' => $cashFlow->id, 'clone' => true]) }}"
                                    icon="document-duplicate"
                                ></x-button.circle>
                                <x-button.circle
                                    flat
                                    wire:navigate
                                    href="{{ route('outflows.edit', ['id' => $cashFlow->id]) }}"
                                    icon="pencil-alt"
                                ></x-button.circle>
                            @endif
                            @livewire('cash-flow.cash-flow-delete-button', [
                                'cashFlow' => $cashFlow
                            ], key($cashFlow->id))
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6">
                    Список пуст
                </div>
            @endforelse

            <div x-show="isLoading" x-transition x-cloak class="p-4 text-center text-lg text-emerald-600">
                Загрузка...
            </div>
        </div>
    </div>
</div>
