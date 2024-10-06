<?php

declare(strict_types=1);

namespace App\Builders;

use App\Builders\Data\CashFlowFilter;
use App\Enums\CashFlowType;
use App\Models\CashFlow;
use App\Models\User;
use Carbon\Carbon;
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

    public function getBalance(?User $user = null): float
    {
        return (float) CashFlow::balance()
            ->when($user, fn (Builder $q) => $q->where('user_id', $user->id))
            ->get()
            ->sum('sum');
    }

    public function balance(?Carbon $date = null): self
    {
        return $this
            ->select(
                DB::raw(sprintf("SUM(case when type = '%s' then -sum else sum end) as sum", CashFlowType::Outflow->value)),
            )
            ->when($date, fn (self $q) => $q->where('date', '<=', $date->endOfDay()));
    }
}
