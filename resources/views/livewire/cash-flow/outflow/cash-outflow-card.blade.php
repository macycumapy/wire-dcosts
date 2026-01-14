<div class="max-w-7xl sm:mx-auto sm:p-4 p-2">
    <x-card :title="$cashFlow ? 'Расход денежных средств' : 'Новый расход денежных средств'" borderless card-classes="h-full" padding="p-2 sm:p-4">
        <div class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <x-datetime-picker
                    wire:model="data.date"
                    name="date"
                    label="Дата"
                    start-of-week="1"
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
                            ], key('new'))
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
                    <x-currency
                        wire:model="data.sum"
                        name="sum"
                        label="Сумма"
                        :min="0"
                        suffix="руб."
                        thousands=" "
                        disabled
                    ></x-currency>
                </div>
            </div>

            <x-card padding="p-0" shadowless>
                <div class="divide-y divide-primary-600 dark:divide-secondary-500 text-xs sm:text-base min-h-[200px]">
                    <div class="grid grid-cols-3 sm:grid-cols-5 gap-2 sm:gap-4 font-semibold bg-white dark:bg-secondary-800 pb-2 sm:p-2">
                        <div class="hidden sm:block">Номенклатура</div>
                        <div>Стоимость</div>
                        <div class="text-center sm:text-left">Количество</div>
                        <div class="text-right sm:text-left">Сумма</div>
                    </div>
                    @foreach($data->details as $itemKey => $item)
                        <div wire:key="row_{{ $itemKey }}" class="grid grid-cols-3 sm:grid-cols-5 gap-2 sm:gap-4 items-center px-1 sm:px-4 py-2">
                            <div class="col-span-3 sm:col-span-1" x-text="$store.nomenclatures?.getName({{ $item->nomenclature_id }})"></div>
                            <div>{{ number_format($item->cost, 2, '.', ' ') }}</div>
                            <div class="text-center sm:text-left">{{ number_format($item->count, 2, '.', ' ') }}</div>
                            <div class="text-right sm:text-left">{{ number_format($item->sum, 2, '.', ' ') }}</div>
                            <div class="flex justify-between items-center gap-4 col-span-3 sm:col-span-1">
                                @livewire('cash-flow.outflow.cash-outflow-item-modal', [
                                    'data' => $item->copy(),
                                ], key(md5('copy'.$itemKey.$item->toJson())))
                                @livewire('cash-flow.outflow.cash-outflow-item-modal', [
                                    'data' => $item,
                                    'detailsIndex' => $itemKey,
                                ], key(md5('edit'.$itemKey.$item->toJson())))
                                <x-mini-button rounded secondary flat
                                    id="delete_{{$itemKey}}"
                                    wire:click="deleteItem({{$itemKey}})"
                                    icon="trash"
                                    class="p-4"
                                ></x-mini-button>
                            </div>
                        </div>
                    @endforeach
                    <div class="flex justify-between py-2">
                        <div><x-error name="details" class="!mt-0"></x-error></div>
                        @livewire('cash-flow.outflow.cash-outflow-item-modal', key('new'))
                    </div>
                </div>
            </x-card>

            <div class="flex justify-between sm:justify-end items-center">
                <div class="sm:hidden text-sm">Итого: {{ number_format($data->sum, 2, '.', ' ') }} руб.</div>
                <div class="flex justify-end space-x-4">
                    @if($cashFlow)
                        <x-button
                            primary
                            wire:click="update"
                            wire:loading.attr="disabled"
                            label="Обновить"
                        ></x-button>
                    @else
                        <x-button
                            primary
                            wire:click="create"
                            wire:loading.attr="disabled"
                            label="Создать"
                        ></x-button>
                    @endif
                    <x-button
                        secondary
                        wire:click="cancel"
                        wire:loading.attr="disabled"
                        label="Отмена"
                    ></x-button>
                </div>
            </div>
        </div>
    </x-card>
</div>
