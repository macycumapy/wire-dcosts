<?php

declare(strict_types=1);

namespace App\Builders;

use App\Builders\Traits\SearchByName;
use App\Models\Account;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method AccountBuilder searchByName(string $name)
 * @mixin Account
 */
class AccountBuilder extends Builder
{
    use SearchByName;
}
