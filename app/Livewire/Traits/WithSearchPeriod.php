<?php

declare(strict_types=1);

namespace App\Livewire\Traits;

use App\Enums\Period;

trait WithSearchPeriod
{
    public string|Period|null $searchPeriod = Period::Month;
    public ?string $searchDateFrom = null;
    public ?string $searchDateTo = null;

    protected function queryStringWithSearchPeriod(): array
    {
        return [
            'searchPeriod' => ['as' => 'period', 'except' => $this->defaultSearchPeriod()],
            'searchDateFrom' => ['as' => 'date_from', 'except' => $this->defaultSearchPeriod()->dateFrom()?->format('d.m.Y')],
            'searchDateTo' => ['as' => 'date_to', 'except' => $this->defaultSearchPeriod()->dateTo()?->format('d.m.Y')],
        ];
    }

    public function mountWithSearchPeriod(): void
    {
        if ($this->searchPeriod) {
            $this->updatedSearchPeriod($this->searchPeriod);
        }
    }

    public function updatedSearchPeriod($period): void
    {
        if (is_string($period)) {
            $period = Period::tryFrom($period) ?? Period::Custom;
        }

        switch ($period) {
            case Period::AllTime:
                $this->searchDateFrom = null;
                $this->searchDateTo = null;
                break;
            case Period::Custom:
                break;
            default:
                $this->searchDateFrom = $period?->dateFrom()->format('d.m.Y');
                $this->searchDateTo = $period?->dateTo()->format('d.m.Y');
        }
    }

    private function resetFiltersWithSearchPeriod(): void
    {
        $this->searchPeriod = $this->defaultSearchPeriod();
        $this->updatedSearchPeriod($this->searchPeriod);
    }

    private function defaultSearchPeriod(): Period
    {
        return Period::Month;
    }
}
