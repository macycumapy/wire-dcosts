<?php

declare(strict_types=1);

namespace App\Builders;

use App\Models\NomenclatureType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @mixin NomenclatureType
 */
class NomenclatureTypeBuilder extends Builder
{
    public function search(string $name): Collection
    {
        return $this->where('name', 'like', "%$name%")->get();
    }
}
