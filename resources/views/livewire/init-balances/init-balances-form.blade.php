<div class="max-w-7xl sm:mx-auto sm:px-6 lg:px-8 sm:my-12 m-2">
    <x-card title="Загрузка начальных балансов">
        <div class="space-y-4">
            <x-select
                wire:model="type"
                :options="\App\Enums\CashFlowType::valuesWithTitles()"
                option-label="title"
                option-value="value"
                option-description="-"
                autocomplete="off" autocorrect="off"
                class="sm:w-1/2"
            ></x-select>
            <div class="sm:w-1/2">
                <x-input.filepond
                    wire:model="file"
                    :file-types="['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']"
                ></x-input.filepond>
                <x-error name="file"></x-error>
            </div>

            <div class="flex justify-end">
                <x-button
                    primary
                    wire:click="uploadFile"
                    label="Загрузить"
                ></x-button>
            </div>
        </div>
    </x-card>
</div>
