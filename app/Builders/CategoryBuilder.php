<?php

declare(strict_types=1);

namespace App\Builders;

use App\Builders\Traits\SearchByName;
use App\Enums\CashFlowType;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method CategoryBuilder searchByName(string $name)
 * @mixin Category
 */
class CategoryBuilder extends Builder
{
    use SearchByName;

    public function ofType(CashFlowType $type): self
    {
        return $this->where('type', $type);
    }
}
