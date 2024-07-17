<div class="space-y-4">
    <x-input
        wire:model="data.name"
        name="name"
        label="Название"
    ></x-input>

    <x-textarea
        wire:model="data.comment"
        name="comment"
        label="Комментарий"
    ></x-textarea>

    <div class="flex justify-end">
        @if($account)
            <x-button
                primary
                wire:click="update"
                wire:loading.attr="disabled"
                label="Обновить"
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
