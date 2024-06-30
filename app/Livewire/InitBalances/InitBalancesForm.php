<?php

declare(strict_types=1);

namespace App\Livewire\InitBalances;

use App\Enums\CashFlowType;
use App\Services\InitialBalances\InitialBalancesService;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;

class InitBalancesForm extends Component
{
    use WireUiActions;
    use WithFileUploads;

    public mixed $file = null;
    public ?string $type = null;


    protected array $rules = [
        'file' => ['required'],
        'type' => ['required'],
    ];

    public function uploadFile(InitialBalancesService $service): void
    {
        $this->validate();
        match (CashFlowType::tryFrom($this->type)) {
            CashFlowType::Inflow => $service->uploadInflows($this->file),
            CashFlowType::Outflow => $service->uploadOutflows($this->file),
        };

        $this->reset('file', 'type');
        $this->notification()->success('Загрузка балансов', 'Файл загружен');
    }

    public function render(): View
    {
        return view('livewire.init-balances.init-balances-form');
    }
}
