<div class="space-y-4">
    <x-input
        wire:model="data.name"
        name="name"
        label="Название"
    ></x-input>

    <div class="flex justify-end">
        @if($partner)
            <x-button
                primary
                wire:click="update"
                wire:loading.attr="disabled"
                label="Изменить"
            ></x-button>
        @else
            <x-button
                primary
                wire:click="create"
                wire:loading.attr="disabled"
                label="Создать"
            ></x-button>
        @endif
    </div>
</div>
