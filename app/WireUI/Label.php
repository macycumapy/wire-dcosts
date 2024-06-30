<?php

declare(strict_types=1);

namespace App\WireUI;

use Illuminate\Contracts\View\View;
use WireUi\Components\Label\Index;

class Label extends Index
{
    public function blade(): View
    {
        return view('vendor.wireui.label');
    }
}
