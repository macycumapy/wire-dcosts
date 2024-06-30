<?php

declare(strict_types=1);

namespace App\WireUI;

use Illuminate\Contracts\View\View;
use WireUi\Components\Select\Base;

class Select extends Base
{
    protected function blade(): View
    {
        return view('vendor.wireui.select');
    }
}
