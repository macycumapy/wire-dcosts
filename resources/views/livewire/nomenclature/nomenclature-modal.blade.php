<div>
    <x-button
        wire:click="$toggle('show')"
        label="Добавить"
    ></x-button>
    <x-modal.card wire:model="show" title="Новая номенклатура">
        @livewire('nomenclature.nomenclature-form')
    </x-modal.card>
</div>
