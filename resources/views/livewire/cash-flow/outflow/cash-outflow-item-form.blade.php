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
        hideEmptyMessage
    >
        <x-slot name="afterOptions">
            <div class="p-2">
                @livewire('nomenclature.nomenclature-modal')
            </div>
        </x-slot>

        @if($data->nomenclature_id)
            <x-slot name="openButton">
                @livewire('nomenclature.nomenclature-modal', [
                    'id' => $data->nomenclature_id
                ], key('nomenclature_'.$data->nomenclature_id))
            </x-slot>
        @endif
    </x-select>
    <div class="grid grid-cols-3 gap-4">
        <x-currency
            wire:model="data.cost"
            x-model.number="cost"
            name="cost"
            label="Стоимость"
            suffix="руб."
            thousands=""
            inputmode="numeric"
            class="col-span-2"
        ></x-currency>
        <x-currency
            wire:model="data.count"
            x-model.number="count"
            name="count"
            label="Количество"
            thousands=""
            inputmode="numeric"
        ></x-currency>
    </div>

    <div class="flex justify-between text-center">
        <div class="flex my-auto">Итого:&nbsp;<span x-text="sum"></span>&nbsp;руб.</div>
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
