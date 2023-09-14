<?php

declare(strict_types=1);

namespace App\Livewire\CashFlow;

use App\Models\CashFlow;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class CashFlowList extends Component
{
    use WithPagination;

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
