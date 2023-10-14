<?php

declare(strict_types=1);

namespace App\Livewire\Traits;

trait WithFilters
{
    public ?int $filterCount = null;

    public function getFilterCount(): int
    {
        return $this->filterCount = collect($this->queryString())
            ->map(fn ($v, $k) => !empty($this->$k) && $this->$k !== data_get($v, 'except'))
            ->sum();
    }

    public function resetFilters(): void
    {
        collect($this->queryString())->each(fn ($k, $v) => $this->$v = null);
    }
}
