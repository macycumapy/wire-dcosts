<?php

declare(strict_types=1);

namespace App\Builders;

use App\Builders\Data\CashFlowFilter;
use App\Enums\CashFlowType;
use App\Models\CashFlow;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * @mixin CashFlow
 */
class CashFlowBuilder extends Builder
{
    public function filteredList(CashFlowFilter $filter): Builder
    {
        return $this
            ->with('category')
            ->when(
                $filter->nomenclatureId,
                fn (Builder $q) => $q->whereRelation('details', 'nomenclature_id', $filter->nomenclatureId)
            )
            ->when(
                $filter->dateFrom,
                fn (Builder $q) => $q->where('date', '>=', $filter->dateFrom->startOfDay())
            )
            ->when(
                $filter->dateTo,
                fn (Builder $q) => $q->where('date', '<=', $filter->dateTo->endOfDay())
            )
            ->orderByDesc('date')
            ->orderBy('id');
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
