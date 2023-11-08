<?php

declare(strict_types=1);

namespace App\Services\ReportBuilders\OutflowsReport\Data;

use Spatie\LaravelData\Data;

class OutflowData extends Data
{
    public string $category;
    public string $nomenclature_type;
    public string $nomenclature;
    public float $sum;
}
