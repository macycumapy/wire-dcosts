<div class="space-y-4">
    <x-input
        wire:model="data.name"
        name="name"
        label="Название"
    ></x-input>

    <x-select
        wire:model.live="data.nomenclature_type_id"
        name="nomenclature_type_id"
        label="Тип номенклатуры"
        :async-data="route('nomenclature-type.search')"
        option-label="name"
        option-value="id"
        option-description="-"
        autocomplete="off" autocorrect="off"
    >
        <x-slot name="emptyMessage">
            @livewire('nomenclature-type.nomenclature-type-modal')
        </x-slot>

        @if($data->nomenclature_type_id)
            <x-slot name="openButton">
                @livewire('nomenclature-type.nomenclature-type-modal', [
                    'id' => $data->nomenclature_type_id,
                ], key('nomenclatureType_' . $data->nomenclature_type_id))
            </x-slot>
        @endif
    </x-select>

    <div class="flex justify-end">
        @if($nomenclature)
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
    </div>
</div>
