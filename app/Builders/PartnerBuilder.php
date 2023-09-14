<?php

declare(strict_types=1);

namespace App\Builders;

use App\Builders\Traits\SearchByName;
use App\Models\Partner;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method searchByName(string $name)
 * @mixin Partner
 */
class PartnerBuilder extends Builder
{
    use SearchByName;
}
