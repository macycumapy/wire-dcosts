<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-12">
    <x-card :title="$cashFlow ? 'Поступление денежных средств' : 'Новое поступление денежных средств'">
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
                            'type' => \App\Enums\CashFlowType::Inflow->value,
                        ]
                    ]"
                    option-label="name"
                    option-value="id"
                    option-description="-"
                    autocomplete="off" autocorrect="off"
                >
                    <x-slot name="emptyMessage">
                        @livewire('category.category-modal', [
                            'type' => \App\Enums\CashFlowType::Inflow,
                        ])
                    </x-slot>

                    @if($data->category_id)
                        <x-slot name="openButton">
                            @livewire('category.category-modal', [
                                'type' => \App\Enums\CashFlowType::Inflow,
                                'id' => $data->category_id
                            ], key('category_' . $data->category_id))
                        </x-slot>
                    @endif
                </x-select>

                <x-select
                    wire:model.live="data.partner_id"
                    name="partner_id"
                    label="От кого"
                    :async-data="route('partners.search')"
                    option-label="name"
                    option-value="id"
                    option-description="-"
                    autocomplete="off" autocorrect="off"
                >
                    <x-slot name="emptyMessage">
                        @livewire('partner.partner-modal')
                    </x-slot>

                    @if($data->partner_id)
                        <x-slot name="openButton">
                            @livewire('partner.partner-modal', [
                                'id' => $data->partner_id
                            ], key('partner_' . $data->partner_id))
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
                ></x-inputs.currency>

            </div>
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
