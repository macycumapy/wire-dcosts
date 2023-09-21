<?php

declare(strict_types=1);

namespace App\Livewire\Widget;

use App\Livewire\CashFlow\CashFlowDeleteButton;
use App\Livewire\CashFlow\Inflow\CashInflowCard;
use App\Livewire\CashFlow\Outflow\CashOutflowCard;
use App\Models\CashFlow;
use Illuminate\View\View;
use Livewire\Component;

class BalancesWidget extends Component
{
    public float $balance = 0.0;

    protected $listeners = [
        CashInflowCard::CASH_INFLOW_CREATED_EVENT => 'getBalance',
        CashOutflowCard::CASH_OUTFLOW_SAVED_EVENT => 'getBalance',
        CashFlowDeleteButton::CASH_FLOW_DELETED_EVENT => 'getBalance',
    ];

    public function mount(): void
    {
        $this->getBalance();
    }

    public function getBalance(): void
    {
        $this->balance = CashFlow::getBalance();
    }

    public function render(): View
    {
        return view('livewire.widget.balances-widget');
    }
}
