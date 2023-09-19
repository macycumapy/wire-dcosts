<?php

declare(strict_types=1);

namespace App\Livewire\CashFlow\Outflow;

use App\Actions\CashOutflowItem\Data\OutflowItemData;
use App\Livewire\Traits\AsModal;
use Illuminate\View\View;
use Livewire\Component;

class CashOutflowItemModal extends Component
{
    use AsModal;

    public ?OutflowItemData $data = null;
    public ?int $detailsIndex = null;
    protected $listeners = [
        CashOutflowItemForm::ITEM_UPDATED_EVENT => 'closeModal',
        CashOutflowItemForm::ITEM_ADDED_EVENT => 'closeModal',
    ];

    public function render(): View
    {
        return view('livewire.cash-flow.outflow.cash-outflow-item-modal');
    }
}
