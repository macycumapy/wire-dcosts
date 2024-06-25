<?php

declare(strict_types=1);

namespace App\Actions\Account;

use App\Actions\Account\Data\AccountData;
use App\Models\Account;

class CreateAccountAction
{
    public function exec(AccountData $data): Account
    {
        $account = new Account();
        $account->name = $data->name;
        $account->comment = $data->comment;
        $account->balance = $data->balance;
        $account->user()->associate($data->user_id);
        $account->save();

        return $account;
    }
}
