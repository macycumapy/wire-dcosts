<?php

declare(strict_types=1);

namespace App\Livewire\Report;

use App\Livewire\Traits\WithFilters;
use App\Livewire\Traits\WithSearchPeriod;
use App\Services\ReportBuilders\OutflowsReport\Data\FilterData;
use App\Services\ReportBuilders\OutflowsReport\OutflowsReportBuilder;
use Illuminate\View\View;
use Livewire\Component;

class OutflowsReport extends Component
{
    use WithFilters;
    use WithSearchPeriod {
        queryStringWithSearchPeriod as queryString;
    }

    public const NO_DATA_FOUND_TEXT = 'Результатов не найдено';

    public function resetFilters(): void
    {
        $this->resetFiltersWithSearchPeriod();
    }

    public function render(OutflowsReportBuilder $report): View
    {
        $items = $report->build(FilterData::from([
            'user' => auth()->user(),
            'dateFrom' => $this->searchDateFrom,
            'dateTo' => $this->searchDateTo,
        ]));

        return view('livewire.report.outflows-report', [
            'items' => $items,
            'total' => $items->sum('sum'),
        ]);
    }
}
