<?php

declare(strict_types=1);

namespace App\Livewire\AccountCashTransfer;

use App\Actions\Account\Exceptions\NotEnoughBalanceException;
use App\Actions\AccountCashTransfer\CreateCashTransferAction;
use App\Actions\AccountCashTransfer\Data\AccountCashTransferData;
use App\Models\AccountCashTransfer;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use WireUi\Traits\Actions;

class AccountCashTransferForm extends Component
{
    use Actions;

    public const ACCOUNT_CASH_TRANSFER_SAVED = 'account_cash_transfer_saved';
    public ?AccountCashTransfer $cashTransfer = null;
    public AccountCashTransferData $data;

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->cashTransfer = AccountCashTransfer::findOrFail($id);
            $this->data = AccountCashTransferData::from($this->cashTransfer);
        } else {
            $this->data = AccountCashTransferData::from([
                'user_id' => Auth::id(),
                'sum' => 0,
                'from_account_id' => Auth::user()->mainAccount?->id
            ]);
        }
    }

    public function create(CreateCashTransferAction $action): void
    {
        try {
            $cashTransfer = $action->exec(AccountCashTransferData::validateAndCreate($this->data));
            $this->dispatch(self::ACCOUNT_CASH_TRANSFER_SAVED, $cashTransfer->id);
            $this->notification()->success('Перевод между счетами', 'Выполнен');
        } catch (NotEnoughBalanceException $e) {
            $this->notification()->error('Перевод между счетами', $e->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.account-cash-transfer.account-cash-transfer-form');
    }
}
