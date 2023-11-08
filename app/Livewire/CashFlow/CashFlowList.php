<?php

declare(strict_types=1);

namespace App\Livewire\CashFlow;

use App\Builders\Data\CashFlowFilter;
use App\Livewire\Traits\WithFilters;
use App\Models\CashFlow;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use WireUi\Traits\Actions;

class CashFlowList extends Component
{
    use Actions;
    use WithFilters;

    public string $timezone;
    public int $perPage = 25;
    public bool $isLoading = false;
    public int $itemsCount = 0;
    public ?int $searchNomenclature = null;
    public ?string $searchDateFrom = null;
    public ?string $searchDateTo = null;

    public $listeners = [
        CashFlowDeleteButton::CASH_FLOW_DELETED_EVENT => '$refresh',
    ];

    public function mount(): void
    {
        $this->timezone = Auth::user()->timezone;
    }

    public function loadMore(): void
    {
        $this->perPage += 20;
        $this->isLoading = false;
    }

    protected function queryString(): array
    {
        return [
            'searchNomenclature' => ['except' => '', 'as' => 'nomenclature'],
            'searchDateFrom' => ['except' => '', 'as' => 'date_from'],
            'searchDateTo' => ['except' => '', 'as' => 'date_to'],
        ];
    }

    public function updated($field): void
    {
        if (array_key_exists($field, $this->queryString())) {
            $this->reset('perPage');
        }
    }

    public function render(): View
    {
        $items = CashFlow::filteredList(CashFlowFilter::from([
            'nomenclatureId' => $this->searchNomenclature,
            'dateFrom' => $this->searchDateFrom,
            'dateTo' => $this->searchDateTo,
        ]))->paginate($this->perPage);
        $this->itemsCount = $items->total();

        return view('livewire.cash-flow.cash-flow-list', [
            'items' => $items,
        ]);
    }
}
