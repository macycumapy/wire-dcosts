<?php

declare(strict_types=1);

namespace App\Services\InitialBalances\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class OutflowData extends Data
{
    public Carbon $date;
    public float $sum;
    public string $categoryName;

    #[DataCollectionOf(OutflowDetailsData::class)]
    public DataCollection $details;
}
