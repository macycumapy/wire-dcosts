<?php

declare(strict_types=1);

namespace App\Livewire\NomenclatureType;

use Illuminate\View\View;
use Livewire\Component;

class NomenclatureTypeModal extends Component
{
    public bool $show = false;

    public function render(): View
    {
        return view('livewire.nomenclature-type.nomenclature-type-modal');
    }
}
