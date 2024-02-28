<?php

declare(strict_types=1);

namespace App\Livewire\CashFlow\Outflow;

use App\Actions\CashFlow\Outflow\CreateCashOutflowAction;
use App\Actions\CashFlow\Outflow\Data\CashOutflowData;
use App\Actions\CashFlow\Outflow\Data\UpdateCashOutflowData;
use App\Actions\CashFlow\Outflow\UpdateCashOutflowAction;
use App\Actions\CashOutflowItem\Data\OutflowItemData;
use App\Enums\CashFlowType;
use App\Livewire\Category\CategoryForm;
use App\Livewire\Traits\WithPreloader;
use App\Models\CashFlow;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use WireUi\Traits\Actions;

class CashOutflowCard extends Component
{
    use Actions;
    use WithPreloader;

    public const CASH_OUTFLOW_SAVED_EVENT = 'cash-outflow-saved';
    public ?CashFlow $cashFlow = null;
    public CashOutflowData $data;
    #[Url]
    public bool $clone = false;
    public $listeners = [
        CategoryForm::CATEGORY_SAVED_EVENT => 'onCreatedNewCategory',
        CashOutflowItemForm::ITEM_ADDED_EVENT => 'addItem',
        CashOutflowItemForm::ITEM_UPDATED_EVENT => 'updateItem',
    ];

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->cashFlow = CashFlow::query()->with('details.nomenclature')->findOrFail($id);
            $this->data = CashOutflowData::createFromCashFlow($this->cashFlow);
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
        $this->data = CashOutflowData::from([
            'user_id' => Auth::id(),
            'type' => CashFlowType::Inflow,
            'date' => now(),
            'details' => [],
        ]);
    }

    public function addItem(?array $data = null): void
    {
        $this->data->details[] = OutflowItemData::from($data ?? [
            'user_id' => Auth::id(),
            'count' => 1,
            'cost' => 0,
        ]);
        $this->data->refreshSum();
    }

    public function updateItem(int $index, array $data): void
    {
        $this->data->details[$index] = OutflowItemData::from($data);
        $this->data->refreshSum();
    }

    public function deleteItem(int $key): void
    {
        $this->data->details->offsetUnset($key);
        $this->data->details = $this->data->details->values();
        $this->data->refreshSum();
    }

    public function onCreatedNewCategory(int $categoryId): void
    {
        $this->data->category_id = $categoryId;
    }

    public function create(CreateCashOutflowAction $action): void
    {
        $outflow = $action->exec(CashOutflowData::validateAndCreate($this->data));
        $this->dispatch(self::CASH_OUTFLOW_SAVED_EVENT, $outflow->id);
        $this->notification()->success('Расход денежных средств', 'Добавлен');
        $this->redirectWithPreloader('dashboard');
    }

    public function update(UpdateCashOutflowAction $action): void
    {
        $action->exec(UpdateCashOutflowData::validateAndCreate([
            ...$this->data->toArray(),
            'cashFlow' => $this->cashFlow,
        ]));
        $this->dispatch(self::CASH_OUTFLOW_SAVED_EVENT, $this->cashFlow->id);
        $this->notification()->success('Расход денежных средств', 'Обновлен');
        $this->redirectWithPreloader('dashboard');
    }

    public function cancel(): void
    {
        $this->redirectRoute('dashboard', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.cash-flow.outflow.cash-outflow-card');
    }
}
