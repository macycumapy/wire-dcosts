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
                label="Изменить"
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
