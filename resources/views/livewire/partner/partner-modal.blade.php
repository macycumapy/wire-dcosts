<div x-data="{name:@entangle('name')}" x-init="$watch('$store.selectSearch', value => name = value)">
    @if($id)
        <x-button
            flat
            wire:click="$toggle('showModal')"
            icon="pencil-alt"
        ></x-button>
    @else
        <x-button
            wire:click="$toggle('showModal')"
            label="Добавить"
        ></x-button>
    @endif
    @if($showModal)
        @teleport('#footer')
            <x-modal.card wire:model="showModal" :title="$id ? 'Контрагент' : 'Новый контрагент'">
                @livewire('partner.partner-form', [
                    'name' => $name,
                    'id' => $id,
                ], key(json_encode([$name, $id])))
            </x-modal.card>
        @endteleport
    @endif
</div>
