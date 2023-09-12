<?php

declare(strict_types=1);

namespace App\Livewire\NomenclatureType;

use App\Livewire\Traits\AsModal;
use Illuminate\View\View;
use Livewire\Component;

class NomenclatureTypeModal extends Component
{
    use AsModal;

    public $listeners = [
        NomenclatureTypeForm::NOMENCLATURE_TYPE_SAVED_EVENT => 'closeModal'
    ];
    public function render(): View
    {
        return view('livewire.nomenclature-type.nomenclature-type-modal');
    }
}
