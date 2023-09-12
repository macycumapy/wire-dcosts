<div>
    <x-button
        wire:click="$toggle('show')"
        label="Добавить"
    ></x-button>
    <x-modal.card wire:model="show">
        @livewire('nomenclature-type.nomenclature-type-form')
    </x-modal.card>
</div>
