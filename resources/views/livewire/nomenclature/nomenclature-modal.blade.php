<div x-data="{name:@entangle('name')}" x-init="$watch('$store.selectSearch', value => name = value)">
    @if($id)
        <x-icon
            wire:click="$toggle('showModal')"
            name="pencil-alt"
            class="w-4 h-4 cursor-pointer hover:text-emerald-700"
        ></x-icon>
    @else
        <x-button
            wire:click="$toggle('showModal')"
            label="Добавить"
        ></x-button>
    @endif
    @if($showModal)
        @teleport('#footer')
            <x-modal.card wire:model="showModal" :title="$id ? 'Номенклатура' : 'Новая номенклатура'">
                @livewire('nomenclature.nomenclature-form', [
                    'name' => $name,
                    'id' => $id,
                ], key(json_encode([$name, $id])))
            </x-modal.card>
        @endteleport
    @endif
</div>
