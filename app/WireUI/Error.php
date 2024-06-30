<?php

declare(strict_types=1);

namespace App\WireUI;

use Illuminate\Contracts\View\View;
use WireUi\Components\Errors\Single;

class Error extends Single
{
    public function blade(): View
    {
        return view('vendor.wireui.error');
    }
}
