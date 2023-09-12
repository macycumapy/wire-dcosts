<div>
    <x-button
        wire:click="$toggle('showModal')"
        label="Добавить"
    ></x-button>
    <x-modal.card wire:model="showModal" title="Новая категория">
        @livewire('category.category-form')
    </x-modal.card>
</div>
