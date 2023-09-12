<div class="space-y-4">
    <x-input
        wire:model="data.name"
        name="name"
    ></x-input>

    <div class="flex justify-end">
        @if($nomenclatureType)
            <x-button
                primary
                wire:click="update"
                label="Обновить"
            ></x-button>
        @else
            <x-button
                primary
                wire:click="create"
                label="Записать"
            ></x-button>
        @endif
    </div>
</div>
