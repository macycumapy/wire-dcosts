<?php

declare(strict_types=1);

namespace App\Builders;

use App\Builders\Traits\SearchByName;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method searchByName(string $name)
 * @mixin Category
 */
class CategoryBuilder extends Builder
{
    use SearchByName;
}
