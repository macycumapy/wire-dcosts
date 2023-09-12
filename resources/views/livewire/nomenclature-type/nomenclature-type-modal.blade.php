<div>
    <x-button
        wire:click="$toggle('showModal')"
        label="Добавить"
    ></x-button>
    @teleport('#footer')
        <x-modal.card wire:model="showModal" title="Новый тип номенклатуры">
            @livewire('nomenclature-type.nomenclature-type-form')
        </x-modal.card>
    @endteleport
</div>
