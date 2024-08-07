<?php

declare(strict_types=1);

namespace App\WireUI;

use Illuminate\Contracts\View\View;
use WireUi\Components\Button\Base;

class Button extends Base
{
    public function blade(): View
    {
        return view('vendor.wireui.button');
    }
}
