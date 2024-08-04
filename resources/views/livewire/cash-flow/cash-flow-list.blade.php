<div>
    <div x-data="{
            isLoading: @entangle('isLoading'),
            itemsCount: @entangle('itemsCount'),
            perPage: @entangle('perPage')
        }" x-init="

        window.onscroll = function () {
            if (window.innerHeight + window.scrollY >= document.body.scrollHeight - 50 && !isLoading && itemsCount > perPage) {
                isLoading = true
                $wire.loadMore()
            }
        }
    " class="min-w-full">
        <div class="sticky top-16 bg-white dark:bg-secondary-800 z-10">
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
                    <x-datetime-picker
                        wire:model.live="searchDateFrom"
                        placeholder="Дата начала"
                        clearable
                        without-time
                        without-timezone
                        start-of-week="1"
                    ></x-datetime-picker>
                </div>
                <div class="sm:col-span-3">
                    <x-datetime-picker
                        wire:model.live="searchDateTo"
                        placeholder="Дата окончания"
                        clearable
                        without-time
                        without-timezone
                        start-of-week="1"
                    ></x-datetime-picker>
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
                                <x-button xs flat label="Действия" icon="plus"></x-button>
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
        </div>

        <div class="divide-y divide-primary-600 dark:divide-secondary-500">
            <div class="grid grid-cols-3 sm:grid-cols-4 p-2 sm:p-4 font-semibold gap-x-4 sticky top-[6.5rem] sm:top-28 shadow-[0_10px_10px_-15px_rgba(0,0,0,0.3)] dark:shadow-md bg-white dark:bg-secondary-800 text-xs sm:text-base">
                <div>Дата</div>
                <div class="text-center sm:text-left">Сумма</div>
                <div class="text-right sm:text-left">Категория</div>
            </div>
            <div id="list" class="divide-y divide-primary-600 dark:divide-secondary-500 min-h-[60vh]">
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
                                    <x-mini-button rounded secondary flat
                                        wire:navigate
                                        href="{{ route('inflows.edit', ['id' => $cashFlow->id, 'clone' => true]) }}"
                                        icon="document-duplicate"
                                    ></x-mini-button>
                                    <x-mini-button rounded secondary flat
                                        wire:navigate
                                        href="{{ route('inflows.edit', ['id' => $cashFlow->id]) }}"
                                        icon="pencil-square"
                                    ></x-mini-button>
                                @else
                                    <x-mini-button rounded secondary flat
                                        wire:navigate
                                        href="{{ route('outflows.edit', ['id' => $cashFlow->id, 'clone' => true]) }}"
                                        icon="document-duplicate"
                                    ></x-mini-button>
                                    <x-mini-button rounded secondary flat
                                        wire:navigate
                                        href="{{ route('outflows.edit', ['id' => $cashFlow->id]) }}"
                                        icon="pencil-square"
                                    ></x-mini-button>
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
