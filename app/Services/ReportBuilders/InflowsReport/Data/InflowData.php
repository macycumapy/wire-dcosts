<?php

declare(strict_types=1);

namespace App\Services\ReportBuilders\InflowsReport\Data;

use Spatie\LaravelData\Data;

class InflowData extends Data
{
    public int $category_id;
    public string $category;
    public string $partner;
    public float $sum;
}
