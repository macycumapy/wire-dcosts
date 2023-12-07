<?php

declare(strict_types=1);

namespace App\Actions\Account;

use App\Models\Account;
use Exception;

class UpdateAccountBalanceAction
{
    /**
     * @throws Exception
     */
    public function exec(Account $account, float $sum): bool
    {
        $account->balance += $sum;
        if ($account->balance < 0) {
            throw new Exception('Баланс не может быть отрицательным');
        }

        return $account->save();
    }
}
