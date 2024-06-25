<?php

declare(strict_types=1);

namespace App\Actions\AccountCashTransfer;

use App\Actions\Account\UpdateAccountBalanceAction;
use App\Models\AccountCashTransfer;
use Exception;
use Illuminate\Support\Facades\DB;

readonly class DeleteAccountCashTransferAction
{
    public function __construct(
        private UpdateAccountBalanceAction $updateAccountBalanceAction,
    ) {
    }

    /**
     * @throws Exception
     */
    public function exec(AccountCashTransfer $accountCashTransfer): bool
    {
        return DB::transaction(function () use ($accountCashTransfer) {

            $this->updateAccountBalanceAction->exec($accountCashTransfer->fromAccount, $accountCashTransfer->sum);
            $this->updateAccountBalanceAction->exec($accountCashTransfer->toAccount, -$accountCashTransfer->sum);

            return $accountCashTransfer->delete();
        });
    }
}
