<div>
    @isset($detailsIndex)
        <x-mini-button rounded secondary flat
            wire:click="$toggle('showModal')"
            icon="pencil-square"
        ></x-mini-button>
    @else
        @isset($data->nomenclature_id)
            <x-mini-button rounded secondary flat
                wire:click="$toggle('showModal')"
                icon="document-duplicate"
            ></x-mini-button>
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
            <x-modal-card wire:model.live="showModal">
                @livewire('cash-flow.outflow.cash-outflow-item-form', [
                    'data' => $data,
                    'detailsIndex' => $detailsIndex,
                ], key('item'.json_encode($data).$detailsIndex))
            </x-modal-card>
        @endteleport
    @endif
</div>
