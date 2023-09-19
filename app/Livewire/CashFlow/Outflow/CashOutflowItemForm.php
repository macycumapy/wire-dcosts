<?php

declare(strict_types=1);

namespace App\Livewire\CashFlow\Outflow;

use App\Actions\CashOutflowItem\Data\OutflowItemData;
use App\Livewire\Nomenclature\NomenclatureForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class CashOutflowItemForm extends Component
{
    public const ITEM_ADDED_EVENT = 'outflow-item-added';
    public const ITEM_UPDATED_EVENT = 'outflow-item-updated';
    public ?OutflowItemData $data;
    public ?int $detailsIndex = null;

    protected $listeners = [
        NomenclatureForm::NOMENCLATURE_SAVED_EVENT => 'onCreatedNewNomenclature',
    ];

    public function mount(?OutflowItemData $data = null): void
    {
        $this->data = $data ?? OutflowItemData::from([
            'user_id' => Auth::id(),
            'count' => 1,
            'cost' => 0,
        ]);
    }

    public function addItem(): void
    {
        $this->dispatch(self::ITEM_ADDED_EVENT, OutflowItemData::validateAndCreate($this->data));
    }

    public function updateItem(): void
    {
        $this->dispatch(self::ITEM_UPDATED_EVENT, $this->detailsIndex, OutflowItemData::validateAndCreate($this->data));
    }

    public function onCreatedNewNomenclature(int $nomenclatureId): void
    {
        $this->data->nomenclature_id = $nomenclatureId;
    }

    public function render(): View
    {
        return view('livewire.cash-flow.outflow.cash-outflow-item-form');
    }
}
