<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Actions\User\AuthUserAction;
use App\Actions\User\Data\AuthUserData;
use Illuminate\View\View;
use Livewire\Component;

class LoginForm extends Component
{
    public AuthUserData|array $authUserData;

    public function mount(): void
    {
        $this->authUserData = new AuthUserData();
    }

    public function login(AuthUserAction $authUserAction): void
    {
        if ($authUserAction->exec(AuthUserData::validateAndCreate($this->authUserData))) {
            $this->redirectRoute('dashboard');
        }
    }

    public function render(): View
    {
        return view('livewire.auth.login-form')
            ->layout('components.layouts.guest');
    }
}
