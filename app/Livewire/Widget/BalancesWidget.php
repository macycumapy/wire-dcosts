<?php

declare(strict_types=1);

namespace App\Livewire\Widget;

use App\Livewire\AccountCashTransfer\AccountCashTransferDeleteButton;
use App\Livewire\AccountCashTransfer\AccountCashTransferForm;
use App\Livewire\CashFlow\CashFlowDeleteButton;
use App\Livewire\CashFlow\Inflow\CashInflowCard;
use App\Livewire\CashFlow\Outflow\CashOutflowCard;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
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
    ];

    public function mount(): void
    {
        $this->mainAccount = Auth::user()->mainAccount;
    }

    public function render(): View
    {
        $accounts = Account::query()->orderByDesc('balance')->get();

        return view('livewire.widget.balances-widget', [
            'accounts' => $accounts,
            'totalBalance' => $accounts->sum('balance'),
        ]);
    }
}
