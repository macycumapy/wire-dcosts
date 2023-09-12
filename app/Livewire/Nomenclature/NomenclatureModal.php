<?php

declare(strict_types=1);

namespace App\Livewire\Nomenclature;

use App\Livewire\Traits\AsModal;
use Illuminate\View\View;
use Livewire\Component;

class NomenclatureModal extends Component
{
    use AsModal;

    public $listeners = [
        NomenclatureForm::NOMENCLATURE_SAVED_EVENT => 'closeModal'
    ];

    public function render(): View
    {
        return view('livewire.nomenclature.nomenclature-modal');
    }
}
