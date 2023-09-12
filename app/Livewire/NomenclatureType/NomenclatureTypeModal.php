<?php

declare(strict_types=1);

namespace App\Livewire\NomenclatureType;

use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportEvents\On;

class NomenclatureTypeModal extends Component
{
    public bool $show = false;

    #[On(NomenclatureTypeForm::NOMENCLATURE_TYPE_SAVED_EVENT)]
    public function close(): void
    {
        $this->show = false;
    }

    public function render(): View
    {
        return view('livewire.nomenclature-type.nomenclature-type-modal');
    }
}
