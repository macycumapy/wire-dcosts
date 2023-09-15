<?php

declare(strict_types=1);

namespace App\Actions\CashFlow;

use App\Models\CashFlow;

class DeleteCashFlowAction
{
    public function exec(CashFlow $cashFlow): bool
    {
        return $cashFlow->delete();
    }
}
