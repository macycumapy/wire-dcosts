<?php

declare(strict_types=1);

namespace App\Builders;

use App\Builders\Traits\SearchByName;
use App\Models\Nomenclature;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method searchByName(string $name)
 * @mixin Nomenclature
 */
class NomenclatureBuilder extends Builder
{
    use SearchByName;
}
