<?php

declare(strict_types=1);

namespace App\Builders;

use App\Builders\Traits\SearchByName;
use App\Models\NomenclatureType;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method NomenclatureTypeBuilder searchByName(string $name)
 * @mixin NomenclatureType
 */
class NomenclatureTypeBuilder extends Builder
{
    use SearchByName;
}
