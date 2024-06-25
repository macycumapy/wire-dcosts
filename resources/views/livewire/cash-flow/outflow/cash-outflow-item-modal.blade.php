<div>
    @isset($detailsIndex)
        <x-button.circle
            flat
            wire:click="$toggle('showModal')"
            icon="pencil-alt"
        ></x-button.circle>
    @else
        @isset($data->nomenclature_id)
            <x-button.circle
                flat
                wire:click="$toggle('showModal')"
                icon="document-duplicate"
            ></x-button.circle>
        @else
            <x-button
                primary
                xs
                outline
                wire:click="$toggle('showModal')"
                label="Добавить"
            ></x-button>
        @endif
    @endisset
    @if($showModal)
        @teleport('#footer')
            <x-modal.card wire:model.live="showModal">
                @livewire('cash-flow.outflow.cash-outflow-item-form', [
                    'data' => $data,
                    'detailsIndex' => $detailsIndex,
                ], key('item'.json_encode($data).$detailsIndex))
            </x-modal.card>
        @endteleport
    @endif
</div>
