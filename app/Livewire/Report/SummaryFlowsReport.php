<?php

declare(strict_types=1);

namespace App\Livewire\Report;

use App\Enums\Period;
use App\Livewire\Traits\WithFilters;
use App\Livewire\Traits\WithSearchPeriod;
use App\Services\ReportBuilders\SummaryReport\Data\FilterData;
use App\Services\ReportBuilders\SummaryReport\SummaryFlowsReportBuilder;
use Illuminate\View\View;
use Livewire\Component;

class SummaryFlowsReport extends Component
{
    use WithFilters;
    use WithSearchPeriod {
        queryStringWithSearchPeriod as queryString;
    }

    public function resetFilters(): void
    {
        $this->resetFiltersWithSearchPeriod();
    }

    private function defaultSearchPeriod(): Period
    {
        return Period::Year;
    }

    public function render(SummaryFlowsReportBuilder $report): View
    {
        $items = $report->build(FilterData::from([
            'user' => auth()->user(),
            'dateFrom' => $this->searchDateFrom,
            'dateTo' => $this->searchDateTo,
        ]));

        return view('livewire.report.summary-flows-report', [
            'items' => $items,
        ]);
    }
}
