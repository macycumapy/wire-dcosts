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

    public $listeners = [
        CashFlowDeleteButton::CASH_FLOW_DELETED_EVENT => '$refresh',
    ];

    public string $timezone;

    public function mount(): void
    {
        $this->timezone = Auth::user()->timezone;
    }

    public function paginationView(): string
    {
        return 'pagination';
    }

    public function render(): View
    {
        return view('livewire.cash-flow.cash-flow-list', [
            'items' => CashFlow::filteredList()->paginate(9)
        ]);
    }
}
