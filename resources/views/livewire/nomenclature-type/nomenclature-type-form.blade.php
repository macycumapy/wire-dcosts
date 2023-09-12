<div>
    <x-input
        wire:model="data.name"
        name="name"
    ></x-input>

    @if($nomenclatureType)
        <x-button
            wire:click="update"
            label="Обновить"
        ></x-button>
    @else
        <x-button
            wire:click="create"
            label="Записать"
        ></x-button>
    @endif
</div>
