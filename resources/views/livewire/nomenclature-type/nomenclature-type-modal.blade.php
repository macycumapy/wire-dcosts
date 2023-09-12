<div>
    <x-button
        wire:click="$toggle('show')"
        label="Добавить"
    ></x-button>
    @teleport('#footer')
        <x-modal.card wire:model="show" title="Новый тип номенклатуры">
            @livewire('nomenclature-type.nomenclature-type-form')
        </x-modal.card>
    @endteleport
</div>
