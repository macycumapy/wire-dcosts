<?php

declare(strict_types=1);

namespace App\Builders;

use App\Models\CashFlow;
use Illuminate\Database\Eloquent\Builder;

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
}
