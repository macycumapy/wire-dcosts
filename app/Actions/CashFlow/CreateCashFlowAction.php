<?php

declare(strict_types=1);

namespace App\Actions\CashFlow;

use App\Actions\CashFlow\Data\CashFlowData;
use App\Models\CashFlow;

class CreateCashFlowAction
{
    public function exec(CashFlowData $data): CashFlow
    {
        return CashFlow::create($data->toArray());
    }
}
