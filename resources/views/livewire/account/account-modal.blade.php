<div>
    @if($id)
        <div wire:click="$toggle('showModal')" class="p-2 cursor-pointer hover:text-emerald-700">
            <x-icon
                name="pencil-alt"
                class="w-4 h-4"
            ></x-icon>
        </div>
    @else
        <x-button
            wire:click="$toggle('showModal')"
            label="Добавить"
        ></x-button>
    @endif
    @if($showModal)
        @teleport('#footer')
        <x-modal.card wire:model.live="showModal" :title="$id ? 'Счет' : 'Новый счет'">
            @livewire('account.account-form', [
                'id' => $id,
            ], key($id))
        </x-modal.card>
        @endteleport
    @endif
</div>
