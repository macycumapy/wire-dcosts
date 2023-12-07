<?php

declare(strict_types=1);

namespace App\Actions\CashFlow\Outflow;

use App\Actions\Account\UpdateAccountBalanceAction;
use App\Actions\CashFlow\Outflow\Data\UpdateCashOutflowData;
use App\Actions\CashOutflowItem\CreateOutflowItemAction;
use App\Actions\CashOutflowItem\Data\OutflowItemData;
use App\Actions\CashOutflowItem\UpdateDetailsAction;
use App\Models\Account;
use App\Models\CashFlow;
use App\Models\CashOutflowItem;
use Exception;
use Illuminate\Support\Facades\DB;

readonly class UpdateCashOutflowAction
{
    public function __construct(
        private CreateOutflowItemAction $createOutflowItemAction,
        private UpdateDetailsAction     $updateDetailsAction,
        private UpdateAccountBalanceAction $updateAccountBalanceAction,
    ) {
    }

    public function exec(UpdateCashOutflowData $data): CashFlow
    {
        return DB::transaction(function () use ($data) {
            $cashFlow = $data->cashFlow;

            $this->updateBalance($data->cashFlow, $data->sum);

            $cashFlow->date = $data->date;
            $cashFlow->category()->associate($data->category_id);
            $cashFlow->sum = $data->sum;
            $cashFlow->save();

            $this->updateDetails($cashFlow, $data);
            $cashFlow->load('details');

            return $cashFlow;
        });
    }

    private function updateDetails(CashFlow $cashFlow, UpdateCashOutflowData $data): void
    {
        $detailsToRemove = $cashFlow->details();

        /** @var OutflowItemData $item */
        foreach ($data->details as $item) {
            if (isset($item->id)) {
                /** @var CashOutflowItem $foundedItem */
                $foundedItem = $cashFlow->details->firstWhere('id', $item->id);
                if ($foundedItem) {
                    $this->updateDetailsAction->exec($foundedItem, $item);
                    $detailsToRemove->where('id', '<>', $item->id);
                } else {
                    $newDetails = $this->createOutflowItemAction->exec($cashFlow, $item);
                    $detailsToRemove->where('id', '<>', $newDetails->id);
                }
            } else {
                $newDetails = $this->createOutflowItemAction->exec($cashFlow, $item);
                $detailsToRemove->where('id', '<>', $newDetails->id);
            }
        }

        if ($detailsToRemove->exists()) {
            $detailsToRemove->delete();
        }
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
