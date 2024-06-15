<?php

declare(strict_types=1);

namespace App\Actions\AccountCashTransfer;

use App\Actions\Account\UpdateAccountBalanceAction;
use App\Actions\AccountCashTransfer\Data\AccountCashTransferData;
use App\Models\AccountCashTransfer;
use Illuminate\Support\Facades\DB;

readonly class CreateCashTransferAction
{
    public function __construct(private UpdateAccountBalanceAction $updateAccountBalanceAction)
    {
    }

    public function exec(AccountCashTransferData $data): AccountCashTransfer
    {
        return DB::transaction(function () use ($data) {
            $accountCashTransfer = new AccountCashTransfer();
            $accountCashTransfer->sum = $data->sum;
            $accountCashTransfer->fromAccount()->associate($data->from_account_id);
            $accountCashTransfer->toAccount()->associate($data->to_account_id);
            $accountCashTransfer->user()->associate($data->user_id);
            $accountCashTransfer->save();

            $this->updateAccountBalanceAction->exec($accountCashTransfer->fromAccount, -$data->sum);
            $this->updateAccountBalanceAction->exec($accountCashTransfer->toAccount, $data->sum);

            return $accountCashTransfer;
        });
    }
}
