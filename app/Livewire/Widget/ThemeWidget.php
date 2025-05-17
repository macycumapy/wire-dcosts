<?php

declare(strict_types=1);

namespace App\Livewire\Widget;

use Illuminate\View\View;
use Livewire\Component;

class ThemeWidget extends Component
{
    public function render(): View
    {
        return view('livewire.widget.theme-widget');
    }
}
