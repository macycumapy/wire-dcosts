<?php

declare(strict_types=1);

namespace App\Livewire\Widget;

use App\Livewire\Account\AccountForm;
use App\Livewire\AccountCashTransfer\AccountCashTransferDeleteButton;
use App\Livewire\AccountCashTransfer\AccountCashTransferForm;
use App\Livewire\CashFlow\CashFlowDeleteButton;
use App\Livewire\CashFlow\Inflow\CashInflowCard;
use App\Livewire\CashFlow\Outflow\CashOutflowCard;
use App\Models\Account;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class BalancesWidget extends Component
{
    public Account $mainAccount;

    protected $listeners = [
        CashInflowCard::CASH_INFLOW_CREATED_EVENT => '$refresh',
        CashOutflowCard::CASH_OUTFLOW_SAVED_EVENT => '$refresh',
        CashFlowDeleteButton::CASH_FLOW_DELETED_EVENT => '$refresh',
        AccountCashTransferDeleteButton::ACCOUNT_CASH_TRANSFER_DELETED => '$refresh',
        AccountCashTransferForm::ACCOUNT_CASH_TRANSFER_SAVED => '$refresh',
        AccountForm::ACCOUNT_SAVED_EVENT => '$refresh',
    ];

    public function mount(): void
    {
        $this->mainAccount = Auth::user()->mainAccount;
    }

    #[Computed]
    public function accounts(): Collection
    {
        return Account::getBalanceList();
    }

    public function render(): View
    {
        return view('livewire.widget.balances-widget');
    }
}
