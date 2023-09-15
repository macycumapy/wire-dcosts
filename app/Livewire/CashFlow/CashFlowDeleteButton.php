<?php

declare(strict_types=1);

namespace App\Livewire\CashFlow;

use App\Actions\CashFlow\DeleteCashFlowAction;
use App\Models\CashFlow;
use Illuminate\View\View;
use Livewire\Component;
use WireUi\Traits\Actions;

class CashFlowDeleteButton extends Component
{
    use Actions;

    public const CASH_FLOW_DELETED_EVENT = 'cash-flow-deleted';
    public CashFlow $cashFlow;

    public function mount(CashFlow $cashFlow): void
    {
        $this->cashFlow = $cashFlow;
    }

    public function confirmDelete(): void
    {
        $this->dialog()->confirm([
            'title' => 'Вы уверены, что хотите удалить запись?',
            'acceptLabel' => 'Да',
            'rejectLabel' => 'Нет',
            'method' => 'delete',
        ]);
    }

    public function delete(DeleteCashFlowAction $action): void
    {
        $action->exec($this->cashFlow);
        $this->notification()->success($this->cashFlow->type->title() . ' денежных средств', 'Удалено');
        $this->dispatch(self::CASH_FLOW_DELETED_EVENT);
    }

    public function render(): View
    {
        return view('livewire.cash-flow.cash-flow-delete-button');
    }
}
