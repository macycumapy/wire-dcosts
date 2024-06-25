<?php

declare(strict_types=1);

namespace App\Actions\CashFlow;

use App\Actions\Account\Exceptions\NotEnoughBalanceException;
use App\Actions\Account\UpdateAccountBalanceAction;
use App\Actions\CashFlow\Data\UpdateCashFlowData;
use App\Models\Account;
use App\Models\CashFlow;
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
            $this->updateBalance($data->cashFlow, $data->account_id, $data->sum);

            return $data->cashFlow->update($data->except('cashFlow')->toArray());
        });
    }

    /**
     * @throws NotEnoughBalanceException
     */
    private function updateBalance(CashFlow $cashFlow, int $newAccountId, float $sum): void
    {
        if ($newAccountId !== $cashFlow->account_id) {
            $newAccount = Account::where('id', $newAccountId)->lockForUpdate()->first();
            $prevAccount = Account::where('id', $cashFlow->account_id)->lockForUpdate()->first();
            $this->updateAccountBalanceAction->exec($prevAccount, $cashFlow->sum * ($cashFlow->isOutflow() ? 1 : -1));
            $this->updateAccountBalanceAction->exec($newAccount, $sum * ($cashFlow->isOutflow() ? -1 : 1));
        } else {
            $diff = ($cashFlow->sum - $sum) * ($cashFlow->isOutflow() ? 1 : -1);
            if ($diff != 0) {
                /** @var Account $account */
                $account = $cashFlow->account()->lockForUpdate()->first();
                $this->updateAccountBalanceAction->exec($account, $diff);
            }
        }
    }
}
