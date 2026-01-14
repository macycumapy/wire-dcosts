<?php

declare(strict_types=1);

namespace App\Livewire\Traits;

use Livewire\Attributes\Computed;

/**
 * @property-read int $filtersCount
 */
trait WithFilters
{
    abstract protected function queryString(): array;

    public function getFilterCount(): int
    {
        return collect($this->queryString())
            ->filter(fn ($v, $k) => !empty($this->$k) && $this->$k !== data_get($v, 'except'))
            ->count();
    }

    public function resetFilters(): void
    {
        $this->reset(array_keys($this->queryString()));
    }

    #[Computed]
    public function filtersCount(): int
    {
        return $this->getFilterCount();
    }

    public function bootWithFilters(): void
    {
        if (!empty(request()->query())) {
            collect($this->queryString())
                ->filter(fn ($k, $v) => in_array($this->$v, ['null', ''], true))
                ->each(fn ($k, $v) => $this->$v = null);
        }
    }
}
