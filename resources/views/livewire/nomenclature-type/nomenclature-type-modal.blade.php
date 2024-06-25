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
    @teleport('#footer')
        <x-modal.card wire:model.live="showModal" :title="$id ? 'Тип номенклатуры' : 'Новый тип номенклатуры'">
            @livewire('nomenclature-type.nomenclature-type-form', [
                'name' => $name,
                'id' => $id,
            ], key(json_encode([$id, $name])))
        </x-modal.card>
    @endteleport
</div>
