<?php

declare(strict_types=1);

namespace App\Actions\Account;

use App\Actions\Account\Data\UpdateAccountData;
use App\Models\Account;

class UpdateAccountAction
{
    public function exec(Account $account, UpdateAccountData $data): bool
    {
        $account->name = $data->name;
        $account->comment = $data->comment;

        return $account->save();
    }
}
