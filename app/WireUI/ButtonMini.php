<?php

declare(strict_types=1);

namespace App\WireUI;

use Illuminate\Contracts\View\View;
use WireUi\Components\Button\Mini;

class ButtonMini extends Mini
{
    public function blade(): View
    {
        return view('vendor.wireui.button-mini');
    }
}
