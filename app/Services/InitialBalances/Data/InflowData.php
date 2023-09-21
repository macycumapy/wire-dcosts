<?php

declare(strict_types=1);

namespace App\Services\InitialBalances\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class InflowData extends Data
{
    public Carbon $date;
    public float $sum;
    public string $categoryName;
    public string $partnerName;
}
