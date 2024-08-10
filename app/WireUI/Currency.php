<?php

declare(strict_types=1);

namespace App\WireUI;

use Illuminate\Contracts\View\View;

class Currency extends \WireUi\Components\TextField\Currency
{
    protected function blade(): View
    {
        return view('vendor.wireui.currency');
    }
}
