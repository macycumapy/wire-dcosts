<div x-data="{
        count:@entangle('data.count'),
        cost:@entangle('data.cost'),
        get sum() { return this.count * this.cost}
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
    <div class="grid grid-cols-3 gap-4">
        <x-inputs.currency
            wire:model="data.count"
            x-model="count"
            name="count"
            label="Количество"
        ></x-inputs.currency>
        <x-inputs.currency
            wire:model="data.cost"
            x-model="cost"
            name="cost"
            label="Стоимость"
            suffix="руб."
            thousands=" "
        ></x-inputs.currency>
        <x-inputs.currency
            wire:model="data.sum"
            x-model="sum"
            label="Итого"
            suffix="руб."
            thousands=" "
            disabled
        ></x-inputs.currency>
    </div>

    <div class="flex justify-end">
        @isset($detailsIndex)
            <x-button
                primary
                wire:click="updateItem"
                label="Обновить"
                class="mb-1"
            ></x-button>
        @else
            <x-button
                primary
                wire:click="addItem"
                label="Добавить"
                class="mb-1"
            ></x-button>
        @endif
    </div>
</div>
