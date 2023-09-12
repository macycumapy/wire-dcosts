<div>
    <x-button
        wire:click="$toggle('showModal')"
        label="Добавить"
    ></x-button>
    <x-modal.card wire:model="showModal" title="Новый контрагент">
        @livewire('partner.partner-form')
    </x-modal.card>
</div>
