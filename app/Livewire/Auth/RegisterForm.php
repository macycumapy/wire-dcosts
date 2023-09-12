<?php

declare(strict_types=1);

namespace App\Livewire\Auth;

use App\Actions\User\AuthUserAction;
use App\Actions\User\CreateUserAction;
use App\Actions\User\Data\AuthUserData;
use App\Actions\User\Data\CreateUserData;
use App\Providers\RouteServiceProvider;
use Illuminate\View\View;
use Livewire\Component;

class RegisterForm extends Component
{
    public CreateUserData $createUserData;

    public function mount(): void
    {
        $this->createUserData = new CreateUserData();
    }

    public function register(CreateUserAction $createUserAction, AuthUserAction $authUserAction): void
    {
        if ($createUserAction->exec(CreateUserData::validateAndCreate($this->createUserData))) {
            $authUserAction->exec(AuthUserData::validateAndCreate([
                'email' => $this->createUserData->email,
                'password' => $this->createUserData->password,
            ]));
            $this->redirect(RouteServiceProvider::HOME);
        }
    }

    public function render(): View
    {
        return view('livewire.auth.register-form')
            ->layout('layouts.guest');
    }
}
