<div>
    <x-button
        wire:click="$toggle('showModal')"
        label="Добавить"
    ></x-button>
    <x-modal.card wire:model="showModal" title="Новая номенклатура">
        @livewire('nomenclature.nomenclature-form')
    </x-modal.card>
</div>
