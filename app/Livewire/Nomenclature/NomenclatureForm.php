<?php

declare(strict_types=1);

namespace App\Livewire\Nomenclature;

use App\Actions\Nomenclature\CreateNomenclatureAction;
use App\Actions\Nomenclature\Data\NomenclatureData;
use App\Actions\Nomenclature\Data\UpdateNomenclatureData;
use App\Actions\Nomenclature\UpdateNomenclatureAction;
use App\Livewire\NomenclatureType\NomenclatureTypeForm;
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
    public ?string $name = null;
    protected $listeners = [
        NomenclatureTypeForm::NOMENCLATURE_TYPE_SAVED_EVENT => 'onNomenclatureTypeCreated',
    ];

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
            'name' => $this->name,
        ]);
    }

    public function create(CreateNomenclatureAction $action): void
    {
        $nomenclature = $action->exec(NomenclatureData::validateAndCreate($this->data));
        $this->dispatch(self::NOMENCLATURE_SAVED_EVENT, $nomenclature->id);
        $this->notification()->success('Номенклатура', 'Добавлена');
        $this->resetData();
    }

    public function update(UpdateNomenclatureAction $action): void
    {
        $action->exec(UpdateNomenclatureData::validateAndCreate([
            ...$this->data->toArray(),
            'nomenclature' => $this->nomenclature,
        ]));
        $this->dispatch(self::NOMENCLATURE_SAVED_EVENT, $this->nomenclature->id);
        $this->notification()->success('Номенклатура', 'Изменена');
    }

    public function onNomenclatureTypeCreated(int $id): void
    {
        $this->data->nomenclature_type_id = $id;
    }

    public function render(): View
    {
        return view('livewire.nomenclature.nomenclature-form');
    }
}
