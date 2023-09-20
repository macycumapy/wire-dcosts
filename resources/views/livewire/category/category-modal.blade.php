<div x-data="{name:@entangle('name')}" x-init="$watch('$store.selectSearch', value => name = value)">
    @if($id)
        <x-icon
            wire:click="$toggle('showModal')"
            name="pencil-alt"
            class="w-4 h-4 cursor-pointer hover:text-emerald-700"
        ></x-icon>
    @else
        <div class="flex justify-between items-center w-full">
            <div>Нет подходящего?</div>
            <x-button
                outline
                primary
                wire:click="$toggle('showModal')"
                icon="plus"
                label="Добавить"
            ></x-button>
        </div>
    @endif
    @if($showModal)
        @teleport('#footer')
            <x-modal.card wire:model="showModal" :title="$id ? 'Категория' : 'Новая категория'">
                @livewire('category.category-form', [
                    'type' => $type,
                    'name' => $name,
                    'id' => $id
                ], key(json_encode([$type, $name, $id])))
            </x-modal.card>
        @endteleport
    @endif
</div>
