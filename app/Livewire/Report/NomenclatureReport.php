<?php

declare(strict_types=1);

namespace App\Livewire\Report;

use App\Livewire\Traits\WithPreload;
use App\Services\ReportBuilders\NomenclatureReport\Data\FilterData;
use App\Services\ReportBuilders\NomenclatureReport\NomenclatureReportBuilder;
use Illuminate\View\View;
use Livewire\Component;

class NomenclatureReport extends Component
{
    use WithPreload;

    public int $searchNomenclatureId;
    public ?int $searchCategoryId = null;
    public ?string $searchDateFrom = null;
    public ?string $searchDateTo = null;

    public function mount(int $id): void
    {
        $this->searchNomenclatureId = $id;
    }

    protected function queryString(): array
    {
        return [
            'searchDateFrom' => ['as' => 'date_from'],
            'searchDateTo' => ['as' => 'date_to'],
            'searchCategoryId' => ['as' => 'category'],
        ];
    }

    public function render(NomenclatureReportBuilder $report): View
    {
        $items = !$this->preload ? $report->build(FilterData::from([
            'user' => auth()->user(),
            'nomenclatureId' => $this->searchNomenclatureId,
            'categoryId' => $this->searchCategoryId,
            'dateFrom' => $this->searchDateFrom,
            'dateTo' => $this->searchDateTo,
        ])) : [];

        return view('livewire.report.nomenclature-report', [
            'items' => $items,
        ]);
    }
}
