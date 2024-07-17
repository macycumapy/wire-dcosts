<div class="space-y-4">
    <x-input
        wire:model="data.name"
        name="name"
        label="Название"
    ></x-input>

    <x-select
        wire:model="data.type"
        wire:key="type"
        id="type"
        name="type"
        label="Тип"
        :options="\App\Enums\CashFlowType::valuesWithTitles()"
        option-label="title"
        option-value="value"
        option-description="-"
        autocomplete="off" autocorrect="off"
        :disabled="isset($type)"
    ></x-select>

    <div class="flex justify-end">
        @if($category)
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
