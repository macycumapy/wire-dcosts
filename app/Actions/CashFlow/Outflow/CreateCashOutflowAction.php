<?php

declare(strict_types=1);

namespace App\Actions\CashFlow\Outflow;

use App\Actions\CashFlow\CreateCashFlowAction;
use App\Actions\CashFlow\Data\CashFlowData;
use App\Actions\CashFlow\Outflow\Data\CashOutflowData;
use App\Actions\CashOutflowItem\CreateOutflowItemAction;
use App\Actions\CashOutflowItem\Data\OutflowItemData;
use App\Models\CashFlow;
use Illuminate\Support\Facades\DB;

readonly class CreateCashOutflowAction
{
    public function __construct(
        private CreateCashFlowAction    $createCashFlowAction,
        private CreateOutflowItemAction $createDetailsAction,
    ) {
    }

    public function exec(CashOutflowData $data): CashFlow
    {
        return DB::transaction(function () use ($data) {
            $cashFlow = $this->createCashFlowAction->exec(CashFlowData::from($data));

            $data->details->each(fn (OutflowItemData $item) => $this->createDetailsAction->exec($cashFlow, $item));

            return $cashFlow;
        });
    }
}
