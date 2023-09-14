<?php

declare(strict_types=1);

namespace App\Actions\CashFlow;

use App\Actions\CashFlow\Data\UpdateCashFlowData;

class UpdateCashFlowAction
{
    public function exec(UpdateCashFlowData $data): bool
    {
        $cashFlow = $data->cashFlow;

        return $cashFlow->update($data->toArray());
    }
}
