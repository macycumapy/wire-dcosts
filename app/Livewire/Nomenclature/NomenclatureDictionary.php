<?php

declare(strict_types=1);

namespace App\Livewire\Nomenclature;

use App\Models\Nomenclature;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class NomenclatureDictionary extends Component
{
    public Collection $nomenclatures;

    protected $listeners = [
        NomenclatureForm::NOMENCLATURE_SAVED_EVENT => 'getNomenclatures',
    ];

    public function mount(): void
    {
        $this->getNomenclatures();
    }

    public function getNomenclatures(): void
    {
        $this->nomenclatures = Nomenclature::query()->get()->map(function (Nomenclature $nomenclature) {
            return [
                'id' => $nomenclature->id,
                'name' => $nomenclature->name,
            ];
        });
    }

    public function render(): View
    {
        return view('livewire.nomenclature.nomenclature-dictionary');
    }
}
