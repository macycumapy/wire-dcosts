<?php

declare(strict_types=1);

namespace App\Builders\Traits;

use Illuminate\Database\Eloquent\Builder;

trait SearchByName
{
    public function searchByName(string $name): Builder
    {
        $name = mb_strtolower($name);

        return $this->whereRaw('lower(name) like ?', ["%$name%"]);
    }
}
