<?php

declare(strict_types=1);

namespace App\Livewire\Account;

use App\Models\Account;
use Illuminate\View\View;
use Livewire\Component;

class AccountList extends Component
{
    protected $listeners = [
        AccountForm::ACCOUNT_SAVED_EVENT => '$refresh',
    ];

    public function render(): View
    {
        return view('livewire.account.account-list', [
            'items' => Account::query()->orderBy('id')->get(),
        ]);
    }
}
