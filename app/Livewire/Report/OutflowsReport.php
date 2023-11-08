<?php

declare(strict_types=1);

namespace App\Livewire\Report;

use App\Livewire\Traits\WithFilters;
use App\Services\ReportBuilders\OutflowsReport\Data\FilterData;
use App\Services\ReportBuilders\OutflowsReport\OutflowsReportBuilder;
use Illuminate\View\View;
use Livewire\Component;

class OutflowsReport extends Component
{
    use WithFilters;

    public const NO_DATA_FOUND_TEXT = 'Результатов не найдено';
    public ?string $searchDateFrom = null;
    public ?string $searchDateTo = null;

    public function mount(): void
    {
        if (empty(request()->query())) {
            $this->searchDateFrom = now()->startOfMonth()->format('d.m.Y');
            $this->searchDateTo = now()->endOfMonth()->format('d.m.Y');
        }
    }

    protected function queryString(): array
    {
        return [
            'searchDateFrom' => ['as' => 'date_from'],
            'searchDateTo' => ['as' => 'date_to'],
        ];
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
