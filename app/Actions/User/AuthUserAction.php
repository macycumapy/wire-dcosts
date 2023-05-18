<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Actions\User\Data\AuthUserData;
use Illuminate\Support\Facades\Auth;

class AuthUserAction
{
    public function exec(AuthUserData $data): bool
    {
        return Auth::attempt(['email' => $data->email, 'password' => $data->password], $data->remember);
    }
}
