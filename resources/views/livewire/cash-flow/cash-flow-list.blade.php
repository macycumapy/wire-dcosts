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
    " class="min-w-full">
        <x-filters :count="$this->filtersCount">
            <div class="sm:col-span-3">
                <x-select
                    wire:model.live="searchNomenclature"
                    :async-data="route('nomenclatures.search')"
                    placeholder="Номенклатура"
                    option-label="name"
                    option-value="id"
                    option-description="-"
                    autocomplete="off" autocorrect="off"
                    hideEmptyMessage
                ></x-select>
            </div>
            <div class="sm:col-span-3">
                <x-date-picker
                    wire:model.live="searchDateFrom"
                    placeholder="Дата начала"
                    clearable
                ></x-date-picker>
            </div>
            <div class="sm:col-span-3">
                <x-date-picker
                    wire:model.live="searchDateTo"
                    placeholder="Дата окончания"
                    clearable
                ></x-date-picker>
            </div>

            <x-slot name="actions">
                <div class="hidden sm:block flex justify-end space-x-4">
                    <x-button
                        primary
                        wire:navigate
                        href="{{ route('inflows.create') }}"
                        icon="plus"
                        label="Поступление"
                        class="w-full sm:w-40"
                    ></x-button>

                    <x-button
                        primary
                        wire:navigate
                        href="{{ route('outflows.create') }}"
                        icon="plus"
                        label="Расход"
                        class="w-full sm:w-40"
                    ></x-button>
                </div>
                <div class="block sm:hidden">
                    <x-dropdown>
                        <x-slot name="trigger">
                            <x-button xs flat label="Действия"></x-button>
                        </x-slot>
                        <x-dropdown.item
                            wire:navigate
                            href="{{ route('inflows.create') }}"
                            icon="plus"
                            label="Поступление"
                        ></x-dropdown.item>
                        <x-dropdown.item
                            wire:navigate
                            href="{{ route('outflows.create') }}"
                            icon="plus"
                            label="Расход"
                        ></x-dropdown.item>
                    </x-dropdown>
                </div>
            </x-slot>
        </x-filters>

        <div class="divide-y divide-gray-500">
            <div class="grid grid-cols-3 sm:grid-cols-4 p-4 sm:px-4 sm:py-2 font-semibold gap-x-4 sticky top-0 bg-gray-800">
                <div>Дата</div>
                <div>Сумма</div>
                <div>Категория</div>
                <div></div>
            </div>
            <div id="list" class="divide-y divide-gray-500 h-[65vh] sm:h-[71vh] 2k:h-[77vh] overflow-auto soft-scrollbar">
                @forelse($items as $key => $cashFlow)
                    <div wire:key="row_{{ $cashFlow->id }}">
                        <div class="p-4 grid grid-cols-3 sm:grid-cols-4 gap-4">
                            <div class="my-auto">
                                {{ $cashFlow->date->timezone($timezone)->isToday() ? 'Сегодня' : $cashFlow->date->timezone($timezone)->format('d.m.Y') }}
                            </div>
                            <div class="my-auto text-{{ $cashFlow->type->color() }}-600 text-center sm:text-left">
                                {{ number_format($cashFlow->sum, 2, '.', ' ') }}
                            </div>
                            <div class="my-auto truncate">
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
</div>
