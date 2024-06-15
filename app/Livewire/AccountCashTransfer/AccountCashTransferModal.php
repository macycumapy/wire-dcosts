<?php

declare(strict_types=1);

namespace App\Livewire\AccountCashTransfer;

use App\Livewire\Traits\AsModal;
use Illuminate\View\View;
use Livewire\Component;

class AccountCashTransferModal extends Component
{
    use AsModal;

    public ?int $id = null;

    public $listeners = [
        AccountCashTransferForm::ACCOUNT_CASH_TRANSFER_SAVED => 'closeModal'
    ];

    public function render(): View
    {
        return view('livewire.account-cash-transfer.account-cash-transfer-modal');
    }
}
