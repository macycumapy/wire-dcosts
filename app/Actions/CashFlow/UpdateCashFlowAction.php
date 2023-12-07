<?php

declare(strict_types=1);

namespace App\Actions\CashFlow;

use App\Actions\Account\UpdateAccountBalanceAction;
use App\Actions\CashFlow\Data\UpdateCashFlowData;
use App\Models\Account;
use App\Models\CashFlow;
use Exception;
use Illuminate\Support\Facades\DB;

readonly class UpdateCashFlowAction
{
    public function __construct(
        private UpdateAccountBalanceAction $updateAccountBalanceAction,
    ) {
    }

    public function exec(UpdateCashFlowData $data): bool
    {
        return DB::transaction(function () use ($data) {
            $this->updateBalance($data->cashFlow, $data->sum);

            return $data->cashFlow->update($data->except('cashFlow')->toArray());
        });
    }

    /**
     * @throws Exception
     */
    private function updateBalance(CashFlow $cashFlow, float $sum): void
    {
        /** @var Account $account */
        $account = $cashFlow->account()->lockForUpdate()->first();

        $diff = ($cashFlow->sum - $sum) * ($cashFlow->isOutflow() ? 1 : -1);

        if ($diff != 0) {
            $this->updateAccountBalanceAction->exec($account, $diff);
        }
    }
}
