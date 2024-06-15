<?php

declare(strict_types=1);

namespace App\Actions\Account;

use App\Actions\Account\Exceptions\NotEnoughBalanceException;
use App\Models\Account;

class UpdateAccountBalanceAction
{
    /**
     * @throws NotEnoughBalanceException
     */
    public function exec(Account $account, float $sum): bool
    {
        $account->balance += $sum;
        if ($account->balance < 0) {
            $currentBalance = number_format($account->getOriginal('balance'), 2, '.', ' ');
            throw new NotEnoughBalanceException("На счету $account->name недостаточно средств: $currentBalance");
        }

        return $account->save();
    }
}
