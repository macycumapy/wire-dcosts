<?php

declare(strict_types=1);

namespace App\Livewire\Account;

use App\Actions\Account\CreateAccountAction;
use App\Actions\Account\Data\AccountData;
use App\Actions\Account\Data\UpdateAccountData;
use App\Actions\Account\UpdateAccountAction;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use WireUi\Traits\Actions;

class AccountForm extends Component
{
    use Actions;

    public const ACCOUNT_SAVED_EVENT = 'accountSaved';
    public ?Account $account = null;
    public AccountData|UpdateAccountData $data;

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->account = Account::findOrFail($id);
            $this->data = UpdateAccountData::from($this->account);
        } else {
            $this->data = AccountData::from([
                'user_id' => Auth::id(),
                'balance' => 0,
            ]);
        }
    }

    public function create(CreateAccountAction $action): void
    {
        $account = $action->exec(AccountData::validateAndCreate($this->data));
        $this->dispatch(self::ACCOUNT_SAVED_EVENT, $account->id);
        $this->notification()->success('Счет', 'Добавлен');
    }

    public function update(UpdateAccountAction $action): void
    {
        $action->exec($this->account, UpdateAccountData::validateAndCreate($this->data));
        $this->dispatch(self::ACCOUNT_SAVED_EVENT, $this->account);
        $this->notification()->success('Счет', 'Обновлен');
    }

    public function render(): View
    {
        return view('livewire.account.account-form');
    }
}
