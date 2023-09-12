<?php

declare(strict_types=1);

namespace App\Livewire\Partner;

use App\Livewire\Traits\AsModal;
use Illuminate\View\View;
use Livewire\Component;

class PartnerModal extends Component
{
    use AsModal;

    public $listeners = [
        PartnerForm::PARTNER_SAVED_EVENT => 'closeModal',
    ];

    public function render(): View
    {
        return view('livewire.partner.partner-modal');
    }
}
