<?php

declare(strict_types=1);

namespace App\Actions\CashFlow;

use App\Actions\Account\UpdateAccountBalanceAction;
use App\Models\Account;
use App\Models\CashFlow;
use Exception;
use Illuminate\Support\Facades\DB;

readonly class DeleteCashFlowAction
{
    public function __construct(
        private UpdateAccountBalanceAction $updateAccountBalanceAction,
    ) {
    }

    /**
     * @throws Exception
     */
    public function exec(CashFlow $cashFlow): bool
    {
        return DB::transaction(function () use ($cashFlow) {
            $this->updateBalance($cashFlow);

            return $cashFlow->delete();
        });
    }

    /**
     * @throws Exception
     */
    private function updateBalance(CashFlow $cashFlow): void
    {
        /** @var Account $account */
        $account = $cashFlow->account()->lockForUpdate()->first();

        $sum = $cashFlow->sum * ($cashFlow->isOutflow() ? 1 : -1);
        $this->updateAccountBalanceAction->exec($account, $sum);
    }
}
