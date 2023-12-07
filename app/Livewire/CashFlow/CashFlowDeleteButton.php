<?php

declare(strict_types=1);

namespace App\Livewire\CashFlow;

use App\Actions\CashFlow\DeleteCashFlowAction;
use App\Models\CashFlow;
use Exception;
use Illuminate\View\View;
use Livewire\Component;
use Throwable;
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

    /**
     * @throws Exception
     */
    public function delete(DeleteCashFlowAction $action): void
    {
        try {
            $action->exec($this->cashFlow);
            $this->notification()->success($this->cashFlow->type->title() . ' денежных средств', 'Удалено');
            $this->dispatch(self::CASH_FLOW_DELETED_EVENT);
        } catch (Throwable $e) {
            $this->notification()->error('Расход денежных средств', $e->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.cash-flow.cash-flow-delete-button');
    }
}
