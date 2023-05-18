<?php

declare(strict_types=1);

namespace App\Http\Livewire\Auth;

use App\Actions\User\CreateUserAction;
use App\Actions\User\Data\CreateUserData;
use Illuminate\View\View;
use Livewire\Component;

class RegisterForm extends Component
{
    public CreateUserData $createUserData;

    public function mount(): void
    {
        $this->createUserData = new CreateUserData();
    }

    public function register(CreateUserAction $createUserAction): void
    {
        $createUserAction->exec(CreateUserData::validateAndCreate($this->createUserData));
    }

    public function render(): View
    {
        return view('livewire.auth.register-form')
            ->layout('layouts.guest');
    }
}
