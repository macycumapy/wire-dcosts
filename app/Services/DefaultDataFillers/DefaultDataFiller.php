<?php

declare(strict_types=1);

namespace App\Services\DefaultDataFillers;

use App\Models\User;

readonly class DefaultDataFiller
{
    public function __construct(private AccountFiller $accountFiller)
    {
    }

    public function fill(User $user): void
    {
        $this->accountFiller->fill($user);
    }
}
