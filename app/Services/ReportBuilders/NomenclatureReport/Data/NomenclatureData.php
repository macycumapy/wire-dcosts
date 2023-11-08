<?php

declare(strict_types=1);

namespace App\Services\ReportBuilders\NomenclatureReport\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class NomenclatureData extends Data
{
    public Carbon $date;
    public float $sum;
    public int $cash_flow_id;
    public string $nomenclature_name;
}
