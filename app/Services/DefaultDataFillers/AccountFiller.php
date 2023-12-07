<?php

declare(strict_types=1);

namespace App\Services\DefaultDataFillers;

use App\Actions\Account\CreateAccountAction;
use App\Actions\Account\Data\AccountData;
use App\Models\Account;
use App\Models\User;

readonly class AccountFiller
{
    public const ACCOUNT_NAME = 'Личный счет';

    public function __construct(private CreateAccountAction $createAccountAction)
    {
    }

    public function fill(User $user, float $sum = 0.0): Account
    {
        return $this->createAccountAction->exec(AccountData::from([
            'user_id' => $user->id,
            'name' => self::ACCOUNT_NAME,
            'balance' => $sum,
        ]));
    }
}
