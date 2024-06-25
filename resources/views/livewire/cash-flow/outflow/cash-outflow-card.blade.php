<div class="max-w-7xl sm:mx-auto sm:px-6 lg:px-8 sm:my-12 m-2">
    <x-card :title="$cashFlow ? 'Расход денежных средств' : 'Новый расход денежных средств'" card-classes="h-full" padding="py-2 sm:py-5 px-2">
        <div class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <x-datetime-picker
                    wire:model="data.date"
                    name="date"
                    label="Дата"
                ></x-datetime-picker>

                <x-select
                    wire:model.live="data.account_id"
                    name="account_id"
                    label="Счет"
                    :async-data="route('accounts.search')"
                    option-label="name"
                    option-value="id"
                    option-description="-"
                    autocomplete="off" autocorrect="off"
                    hideEmptyMessage
                ></x-select>

                <x-select
                    wire:model.live="data.category_id"
                    name="category_id"
                    label="Категория"
                    :async-data="[
                        'api' => route('categories.search'),
                        'params' => [
                            'type' => \App\Enums\CashFlowType::Outflow->value,
                        ]
                    ]"
                    option-label="name"
                    option-value="id"
                    option-description="-"
                    autocomplete="off" autocorrect="off"
                    hideEmptyMessage
                >
                    <x-slot name="afterOptions">
                        <div class="p-4 w-full">
                            @livewire('category.category-modal', [
                                'type' => \App\Enums\CashFlowType::Outflow,
                            ])
                        </div>
                    </x-slot>

                    @if($data->category_id)
                        <x-slot name="openButton">
                            @livewire('category.category-modal', [
                                'type' => \App\Enums\CashFlowType::Outflow,
                                'id' => $data->category_id
                            ], key('category_' . $data->category_id))
                        </x-slot>
                    @endif
                </x-select>

                <div class="hidden sm:block">
                    <x-inputs.currency
                        wire:model="data.sum"
                        name="sum"
                        label="Сумма"
                        :min="0"
                        suffix="руб."
                        thousands=" "
                        disabled
                    ></x-inputs.currency>
                </div>
            </div>

            <x-card title="Детали" card-classes="border-2 border-emerald-800" padding="py-0 sm:py-5 px-1 sm:px-2">
                <x-slot name="action">
                    @livewire('cash-flow.outflow.cash-outflow-item-modal', key('new'))
                </x-slot>

                <div class="divide-y divide-emerald-800 h-[38vh] sm:h-[52vh] 2k:h-[62vh] overflow-auto soft-scrollbar text-xs sm:text-base">
                    <div class="grid grid-cols-3 sm:grid-cols-5 gap-2 sm:gap-4 font-semibold sticky top-0 bg-gray-800 border-b border-emerald-800 pr-1 sm:p-2">
                        <div class="hidden sm:block">Номенклатура</div>
                        <div>Стоимость</div>
                        <div class="text-center sm:text-left">Количество</div>
                        <div class="text-right sm:text-left">Сумма</div>
                        <div></div>
                    </div>
                    @forelse($data->details as $key => $item)
                        <div wire:key="row_{{ $key }}" class="grid grid-cols-3 sm:grid-cols-5 gap-2 sm:gap-4 flex items-center px-1 sm:px-4 py-2">
                            <div class="col-span-3 sm:col-span-1" x-text="$store.nomenclatures?.getName({{ $item->nomenclature_id }})"></div>
                            <div>{{ number_format($item->cost, 2, '.', ' ') }}</div>
                            <div class="text-center sm:text-left">{{ number_format($item->count, 2, '.', ' ') }}</div>
                            <div class="text-right sm:text-left">{{ number_format($item->sum, 2, '.', ' ') }}</div>
                            <div class="flex justify-between items-center gap-4 col-span-3 sm:col-span-1">
                                @livewire('cash-flow.outflow.cash-outflow-item-modal', [
                                    'data' => $item->copy(),
                                ], key('copy'.$key . $item->toJson()))
                                @livewire('cash-flow.outflow.cash-outflow-item-modal', [
                                    'data' => $item,
                                    'detailsIndex' => $key,
                                ], key('edit'.$key . $item->toJson()))
                                <x-button.circle
                                    id="delete_{{$key}}"
                                    flat
                                    wire:click="deleteItem({{$key}})"
                                    icon="trash"
                                    class="p-4"
                                ></x-button.circle>
                            </div>
                        </div>
                    @empty
                        <div><x-error name="details"></x-error></div>
                    @endforelse
                </div>
            </x-card>

            <div class="flex justify-between sm:justify-end items-center">
                <div class="sm:hidden text-sm">Итого: {{ number_format($data->sum, 2, '.', ' ') }} руб.</div>
                <div class="flex justify-end space-x-4">
                    @if($cashFlow)
                        <x-button
                            primary
                            wire:click="update"
                            label="Обновить"
                        ></x-button>
                    @else
                        <x-button
                            primary
                            wire:click="create"
                            label="Создать"
                        ></x-button>
                    @endif
                    <x-button
                        secondary
                        wire:click="cancel"
                        label="Отмена"
                    ></x-button>
                </div>
            </div>
        </div>
    </x-card>
</div>
