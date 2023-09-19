<div
     class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-12" >
    <x-card :title="$cashFlow ? 'Расход денежных средств' : 'Новый расход денежных средств'">
        <div class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <x-datetime-picker
                    wire:model="data.date"
                    name="date"
                    label="Дата"
                ></x-datetime-picker>
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
                >
                    <x-slot name="emptyMessage">
                        @livewire('category.category-modal', [
                            'type' => \App\Enums\CashFlowType::Outflow,
                        ])
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

            <x-card title="Детали" card-classes="border-2 border-emerald-800">
                <x-slot name="action">
                    @livewire('cash-flow.outflow.cash-outflow-item-modal', key('new'))
                </x-slot>

                <div class="divide-y divide-emerald-800 h-[30vh] sm:h-[45vh] overflow-auto soft-scrollbar">
                    <div class="grid grid-cols-4 gap-4 font-semibold sticky top-0 bg-gray-800 border-b border-emerald-800">
                        <div>Номенклатура</div>
                        <div>Количество</div>
                        <div>Стоимость</div>
                        <div>Сумма</div>
                    </div>
                    @foreach($data->details as $key => $item)
                        <div wire:key="row_{{ $key }}" class="grid grid-cols-4 gap-4 flex items-center px-4 py-1">
                            <div x-text="$store.nomenclatures?.getName({{ $item->nomenclature_id }})"></div>
                            <div>{{ number_format($item->count, 2, '.', ' ') }}</div>
                            <div>{{ number_format($item->cost, 2, '.', ' ') }}</div>
                            <div class="flex justify-end items-center space-x-4">
                                <div>{{ number_format($item->sum, 2, '.', ' ') }}</div>
                                <div class="flex justify-end items-center gap-4">
                                    @livewire('cash-flow.outflow.cash-outflow-item-modal', [
                                        'data' => $item,
                                        'detailsIndex' => $key,
                                    ], key('edit'.$key . $item->toJson()))
                                    @livewire('cash-flow.outflow.cash-outflow-item-modal', [
                                        'data' => $item->copy(),
                                    ], key('copy'.$key . $item->toJson()))
                                    <x-button.circle
                                        id="delete_{{$key}}"
                                        flat
                                        wire:click="deleteItem({{$key}})"
                                        icon="trash"
                                        class="mb-1"
                                    ></x-button.circle>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-card>


            <x-errors></x-errors>

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
    </x-card>
</div>
