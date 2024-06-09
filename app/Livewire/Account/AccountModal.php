<?php

declare(strict_types=1);

namespace App\Livewire\Account;

use App\Livewire\Traits\AsModal;
use Illuminate\View\View;
use Livewire\Component;

class AccountModal extends Component
{
    use AsModal;

    public ?int $id = null;

    public $listeners = [
        AccountForm::ACCOUNT_SAVED_EVENT => 'closeModal'
    ];

    public function render(): View
    {
        return view('livewire.account.account-modal');
    }
}
