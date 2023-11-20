<div x-data="{
        count:@entangle('data.count'),
        cost:@entangle('data.cost'),
        get sum() { return (this.count * this.cost).toFixed(2) }
    }" class="space-y-4">
    <x-select
        wire:model.live="data.nomenclature_id"
        name="nomenclature_id"
        label="Номенклатура"
        :async-data="route('nomenclatures.search')"
        option-label="name"
        option-value="id"
        option-description="-"
        autocomplete="off" autocorrect="off"
    >
        <x-slot name="emptyMessage">
            @livewire('nomenclature.nomenclature-modal')
        </x-slot>

        @if($data->nomenclature_id)
            <x-slot name="openButton">
                @livewire('nomenclature.nomenclature-modal', [
                    'id' => $data->nomenclature_id
                ], key('nomenclature_'.$data->nomenclature_id))
            </x-slot>
        @endif
    </x-select>
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
        <x-inputs.currency
            wire:model="data.cost"
            x-model.number="cost"
            name="cost"
            label="Стоимость"
            suffix="руб."
            thousands=""
            inputmode="numeric"
        ></x-inputs.currency>
        <x-inputs.currency
            wire:model="data.count"
            x-model.number="count"
            name="count"
            label="Количество"
            thousands=""
            inputmode="numeric"
        ></x-inputs.currency>
        <div class="hidden sm:block">
            <x-inputs.currency
                wire:model="data.sum"
                x-model="sum"
                label="Итого"
                suffix="руб."
                thousands=" "
                disabled
            ></x-inputs.currency>
        </div>
    </div>

    <div class="flex justify-between sm:justify-end text-center">
        <div class="sm:hidden flex">Итого:&nbsp;<span x-text="sum"></span>&nbsp;руб.</div>
        @isset($detailsIndex)
            <x-button
                primary
                wire:click="updateItem"
                label="Обновить"
                class="mb-1"
                :disabled="$disabledButtons"
            ></x-button>
        @else
            <x-button
                primary
                wire:click="addItem"
                label="Добавить"
                class="mb-1"
                :disabled="$disabledButtons"
            ></x-button>
        @endif
    </div>
</div>
