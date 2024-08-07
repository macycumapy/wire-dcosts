<?php

declare(strict_types=1);

namespace App\Livewire\NomenclatureType;

use App\Actions\NomenclatureType\CreateNomenclatureTypeAction;
use App\Actions\NomenclatureType\Data\NomenclatureTypeData;
use App\Actions\NomenclatureType\Data\UpdateNomenclatureTypeData;
use App\Actions\NomenclatureType\UpdateNomenclatureTypeAction;
use App\Models\NomenclatureType;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class NomenclatureTypeForm extends Component
{
    use WireUiActions;

    public const NOMENCLATURE_TYPE_SAVED_EVENT = 'nomenclatureTypeSaved';
    public ?NomenclatureType $nomenclatureType = null;
    public NomenclatureTypeData $data;
    public ?string $name = null;

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->nomenclatureType = NomenclatureType::findOrFail($id);
            $this->data = NomenclatureTypeData::from($this->nomenclatureType);
        } else {
            $this->resetData();
        }
    }

    private function resetData(): void
    {
        $this->data = NomenclatureTypeData::from([
            'user_id' => Auth::id(),
            'name' => $this->name,
        ]);
    }

    public function create(CreateNomenclatureTypeAction $action): void
    {
        $nomenclatureType = $action->exec(NomenclatureTypeData::validateAndCreate($this->data));
        $this->dispatch(self::NOMENCLATURE_TYPE_SAVED_EVENT, $nomenclatureType->id);
        $this->notification()->success('Тип номенклатуры', 'Добавлен');
        $this->resetData();
    }

    public function update(UpdateNomenclatureTypeAction $action): void
    {
        $action->exec(UpdateNomenclatureTypeData::validateAndCreate([
            ...$this->data->toArray(),
            'nomenclatureType' => $this->nomenclatureType,
        ]));
        $this->dispatch(self::NOMENCLATURE_TYPE_SAVED_EVENT, $this->nomenclatureType->id);
        $this->notification()->success('Тип номенклатуры', 'Изменен');
    }

    public function render(): View
    {
        return view('livewire.nomenclature-type.nomenclature-type-form');
    }
}
