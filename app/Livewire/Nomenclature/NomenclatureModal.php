<?php

declare(strict_types=1);

namespace App\Livewire\Nomenclature;

use Illuminate\View\View;
use Livewire\Component;
use Livewire\Features\SupportEvents\On;

class NomenclatureModal extends Component
{
    public bool $show = false;

    #[On(NomenclatureForm::NOMENCLATURE_SAVED_EVENT)]
    public function close(): void
    {
        $this->show = false;
    }

    public function render(): View
    {
        return view('livewire.nomenclature.nomenclature-modal');
    }
}
