<div class="space-y-4">
    <x-inputs.currency
        wire:model="data.sum"
        name="sum"
        label="Сумма"
        :min="0"
        suffix="руб."
        thousands=" "
        inputmode="numeric"
        :disabled="$cashTransfer"
    ></x-inputs.currency>

    <x-select
        wire:model.live="data.from_account_id"
        name="from_account_id"
        label="Со счета"
        :async-data="route('accounts.search')"
        option-label="name"
        option-value="id"
        option-description="-"
        autocomplete="off" autocorrect="off"
        hideEmptyMessage
        :disabled="$cashTransfer"
    ></x-select>

    <x-select
        wire:model.live="data.to_account_id"
        name="to_account_id"
        label="На счет"
        :async-data="route('accounts.search')"
        option-label="name"
        option-value="id"
        option-description="-"
        autocomplete="off" autocorrect="off"
        hideEmptyMessage
        :disabled="$cashTransfer"
    ></x-select>

    @unless($cashTransfer)
        <div class="flex justify-end">
            <x-button
                primary
                wire:click="create"
                label="Создать"
            ></x-button>
        </div>
    @endif
</div>
