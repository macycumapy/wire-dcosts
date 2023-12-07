<?php

declare(strict_types=1);

namespace App\Livewire\CashFlow\Inflow;

use App\Actions\CashFlow\CreateCashFlowAction;
use App\Actions\CashFlow\Data\CashFlowData;
use App\Actions\CashFlow\Data\UpdateCashFlowData;
use App\Actions\CashFlow\UpdateCashFlowAction;
use App\Enums\CashFlowType;
use App\Livewire\Category\CategoryForm;
use App\Livewire\Partner\PartnerForm;
use App\Livewire\Traits\WithPreloader;
use App\Models\CashFlow;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Throwable;
use WireUi\Traits\Actions;

class CashInflowCard extends Component
{
    use Actions;
    use WithPreloader;

    public const CASH_INFLOW_CREATED_EVENT = 'cash-inflow-created';
    public ?CashFlow $cashFlow = null;
    public CashFlowData $data;
    #[Url]
    public bool $clone = false;
    public $listeners = [
        CategoryForm::CATEGORY_SAVED_EVENT => 'onCreatedNewCategory',
        PartnerForm::PARTNER_SAVED_EVENT => 'onCreatedNewPartner',
    ];

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->cashFlow = CashFlow::findOrFail($id);
            $this->data = CashFlowData::from($this->cashFlow);
            if ($this->clone) {
                $this->cashFlow = null;
                $this->data->date = now();
            }
        } else {
            $this->resetData();
        }
    }

    private function resetData(): void
    {
        $this->data = CashFlowData::from([
            'user_id' => Auth::id(),
            'type' => CashFlowType::Inflow,
            'date' => now(),
            'sum' => 0.0,
            'account_id' => Auth::user()->mainAccount->id, //todo Вынести в настройки
        ]);
    }

    public function onCreatedNewCategory(int $category_id): void
    {
        $this->data->category_id = $category_id;
    }

    public function onCreatedNewPartner(int $partner_id): void
    {
        $this->data->partner_id = $partner_id;
    }

    public function create(CreateCashFlowAction $action): void
    {
        $inflow = $action->exec(CashFlowData::validateAndCreate($this->data));
        $this->dispatch(self::CASH_INFLOW_CREATED_EVENT, $inflow->id);
        $this->notification()->success('Поступление денежных средств', 'Добавлено');
        $this->redirectWithPreloader('dashboard');
    }

    public function update(UpdateCashFlowAction $action): void
    {
        try {
            $action->exec(UpdateCashFlowData::validateAndCreate([
                'cashFlow' => $this->cashFlow,
                ...$this->data->toArray(),
            ]));
            $this->dispatch(self::CASH_INFLOW_CREATED_EVENT, $this->cashFlow->id);
            $this->notification()->success('Поступление денежных средств', 'Обновлено');
            $this->redirectWithPreloader('dashboard');
        } catch (Throwable $e) {
            $this->notification()->error('Поступление денежных средств', $e->getMessage());
        }
    }

    public function cancel(): void
    {
        $this->redirectRoute('dashboard', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.cash-flow.inflow.cash-inflow-card');
    }
}
