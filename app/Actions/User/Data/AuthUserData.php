<?php

declare(strict_types=1);

namespace App\Actions\User\Data;

use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class AuthUserData extends Data implements Wireable
{
    use WireableData;

    public ?string $email = null;
    public ?string $password = null;
    public bool $remember = false;

    public static function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    public static function messages(): array
    {
        return [
            'email.required' => 'Ошибка. Вы не ввели E-Mail',
            'email.email' => 'Ошибка. Введенный E-Mail не валиден',
            'password.required' => 'Ошибка. Вы не ввели пароль',
        ];
    }
}
