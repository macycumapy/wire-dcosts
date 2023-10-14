<?php

declare(strict_types=1);

namespace App\Builders\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class CashFlowFilter extends Data
{
    public ?int $nomenclatureId = null;
    public ?Carbon $dateFrom = null;
    public ?Carbon $dateTo = null;
}
