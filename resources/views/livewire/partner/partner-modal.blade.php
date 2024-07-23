<div x-data="{name:@entangle('name')}" x-init="$watch('$store.selectSearch', value => name = value)">
    @if($id)
        <x-icon
            wire:click.stop="$toggle('showModal')"
            name="pencil-square"
            class="w-4 h-4 cursor-pointer hover:text-emerald-700"
        ></x-icon>
    @else
        <div class="flex justify-between items-center w-full">
            <div>Нет подходящего?</div>
            <x-button
                wire:click="$toggle('showModal')"
                label="Добавить"
            ></x-button>
        </div>
    @endif
    @if($showModal)
        @teleport('#footer')
            <x-modal-card wire:model.live="showModal" :title="$id ? 'Контрагент' : 'Новый контрагент'">
                @livewire('partner.partner-form', [
                    'name' => $name,
                    'id' => $id,
                ], key(json_encode([$name, $id])))
            </x-modal-card>
        @endteleport
    @endif
</div>
