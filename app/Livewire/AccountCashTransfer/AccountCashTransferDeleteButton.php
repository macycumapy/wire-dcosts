<?php

declare(strict_types=1);

namespace App\Livewire\AccountCashTransfer;

use App\Actions\Account\Exceptions\NotEnoughBalanceException;
use App\Actions\AccountCashTransfer\DeleteAccountCashTransferAction;
use App\Models\AccountCashTransfer;
use Exception;
use Illuminate\View\View;
use Livewire\Component;
use WireUi\Traits\Actions;

class AccountCashTransferDeleteButton extends Component
{
    use Actions;

    public const ACCOUNT_CASH_TRANSFER_DELETED = 'account-cash-transfer-deleted';
    public AccountCashTransfer $cashTransfer;

    public function mount(AccountCashTransfer $cashTransfer): void
    {
        $this->cashTransfer = $cashTransfer;
    }

    public function confirmDelete(): void
    {
        $this->dialog()->confirm([
            'title' => 'Вы уверены, что хотите удалить перевод между счетами?',
            'acceptLabel' => 'Да',
            'rejectLabel' => 'Нет',
            'method' => 'delete',
        ]);
    }

    /**
     * @throws Exception
     */
    public function delete(DeleteAccountCashTransferAction $action): void
    {
        try {
            $action->exec($this->cashTransfer);
            $this->notification()->success('Перевод между счетами', 'Удален');
            $this->dispatch(self::ACCOUNT_CASH_TRANSFER_DELETED);
        } catch (NotEnoughBalanceException $e) {
            $this->notification()->error('Перевод между счетами', $e->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.account-cash-transfer.account-cash-transfer-delete-button');
    }
}
