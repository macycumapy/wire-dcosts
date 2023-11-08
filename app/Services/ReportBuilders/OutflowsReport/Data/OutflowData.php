<?php

declare(strict_types=1);

namespace App\Services\ReportBuilders\OutflowsReport\Data;

use Spatie\LaravelData\Data;

class OutflowData extends Data
{
    public int $category_id;
    public string $category;
    public string $nomenclature_type;
    public int $nomenclature_id;
    public string $nomenclature;
    public float $sum;
}
