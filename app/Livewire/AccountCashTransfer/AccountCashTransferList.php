<?php

declare(strict_types=1);

namespace App\Livewire\AccountCashTransfer;

use App\Models\AccountCashTransfer;
use Illuminate\View\View;
use Livewire\Component;

class AccountCashTransferList extends Component
{
    protected $listeners = [
        AccountCashTransferForm::ACCOUNT_CASH_TRANSFER_SAVED => '$refresh',
        AccountCashTransferDeleteButton::ACCOUNT_CASH_TRANSFER_DELETED => '$refresh',
    ];

    public function render(): View
    {
        return view('livewire.account-cash-transfer.account-cash-transfer-list', [
            'items' => AccountCashTransfer::query()->with(['fromAccount', 'toAccount'])->orderByDesc('id')->get()
        ]);
    }
}
