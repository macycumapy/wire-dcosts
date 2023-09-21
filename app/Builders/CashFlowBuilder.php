<?php

declare(strict_types=1);

namespace App\Builders;

use App\Enums\CashFlowType;
use App\Models\CashFlow;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * @mixin CashFlow
 */
class CashFlowBuilder extends Builder
{
    public function filteredList(): Builder
    {
        return $this
            ->with('category')
            ->orderByDesc('date');
    }

    public function getBalance(): float
    {
        $outflowType = CashFlowType::Outflow->value;

        return (float) CashFlow::query()
            ->select(
                'user_id',
                DB::raw("SUM(case when type = '$outflowType' then -sum else sum end) as sum"),
            )
            ->groupBy('user_id')
            ->get()
            ->sum('sum');
    }
}
