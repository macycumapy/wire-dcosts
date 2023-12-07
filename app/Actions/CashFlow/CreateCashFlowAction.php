<?php

declare(strict_types=1);

namespace App\Actions\CashFlow;

use App\Actions\Account\UpdateAccountBalanceAction;
use App\Actions\CashFlow\Data\CashFlowData;
use App\Models\Account;
use App\Models\CashFlow;
use Exception;
use Illuminate\Support\Facades\DB;

readonly class CreateCashFlowAction
{
    public function __construct(
        private UpdateAccountBalanceAction $updateAccountBalanceAction,
    ) {
    }

    public function exec(CashFlowData $data): CashFlow
    {
        return DB::transaction(function () use ($data) {
            $cashFlow = CashFlow::create($data->toArray());

            $this->updateBalance($cashFlow);

            return $cashFlow;
        });
    }

    /**
     * @throws Exception
     */
    private function updateBalance(CashFlow $cashFlow): void
    {
        /** @var Account $account */
        $account = $cashFlow->account()->lockForUpdate()->first();

        $sum = $cashFlow->sum * ($cashFlow->isOutflow() ? -1 : 1);
        $this->updateAccountBalanceAction->exec($account, $sum);
    }
}
