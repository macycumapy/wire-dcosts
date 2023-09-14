<?php

declare(strict_types=1);

namespace App\Builders\Traits;

use Illuminate\Support\Collection;

trait SearchByName
{
    public function searchByName(string $name): Collection
    {
        return $this->where('name', 'like', "%$name%")->get();
    }
}
