<?php

declare(strict_types=1);

namespace App\Livewire\CashFlow;

use App\Models\CashFlow;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class CashFlowList extends Component
{
    use Actions;
    use WithPagination;

    public string $timezone;
    public int $perPage = 25;
    public bool $isLoading = false;
    public int $itemsCount = 0;

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

    public function render(): View
    {
        $items = CashFlow::filteredList()->paginate($this->perPage);
        $this->itemsCount = $items->total();

        return view('livewire.cash-flow.cash-flow-list', [
            'items' => $items,
        ]);
    }
}
