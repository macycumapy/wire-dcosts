<?php

declare(strict_types=1);

namespace App\Livewire\Nomenclature;

use App\Actions\Nomenclature\CreateNomenclatureAction;
use App\Actions\Nomenclature\Data\NomenclatureData;
use App\Actions\Nomenclature\Data\UpdateNomenclatureData;
use App\Actions\Nomenclature\UpdateNomenclatureAction;
use App\Models\Nomenclature;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use WireUi\Traits\Actions;

class NomenclatureForm extends Component
{
    use Actions;

    public const NOMENCLATURE_SAVED_EVENT = 'nomenclatureSaved';
    public ?Nomenclature $nomenclature = null;
    public NomenclatureData $data;

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->nomenclature = Nomenclature::findOrFail($id);
            $this->data = NomenclatureData::from($this->nomenclature);
        } else {
            $this->resetData();
        }
    }

    private function resetData(): void
    {
        $this->data = NomenclatureData::from([
            'user_id' => Auth::id(),
        ]);
    }

    public function create(CreateNomenclatureAction $action): void
    {
        $action->exec(NomenclatureData::validateAndCreate($this->data));
        $this->dispatch(self::NOMENCLATURE_SAVED_EVENT);
        $this->notification()->success('Номенклатура', 'Добавлена');
        $this->resetData();
    }

    public function update(UpdateNomenclatureAction $action): void
    {
        $action->exec(UpdateNomenclatureData::validateAndCreate([
            ...$this->data->toArray(),
            'nomenclature' => $this->nomenclature,
        ]));
        $this->dispatch(self::NOMENCLATURE_SAVED_EVENT);
        $this->notification()->success('Номенклатура', 'Изменена');
    }

    public function render(): View
    {
        return view('livewire.nomenclature.nomenclature-form');
    }
}
