<?php

declare(strict_types=1);

namespace App\WireUI;

use Illuminate\Contracts\View\View;

class TextField extends \WireUi\Components\Wrapper\TextField
{
    public function blade(): View
    {
        return view('vendor.wireui.text-field');
    }
}
