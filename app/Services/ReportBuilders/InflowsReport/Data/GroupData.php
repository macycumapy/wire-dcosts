<?php

declare(strict_types=1);

namespace App\Services\ReportBuilders\InflowsReport\Data;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class GroupData extends Data
{
    #[Computed]
    public float $sum;

    public function __construct(
        public string $name,
        public Collection $details,
    ) {
        $this->sum = $details->sum('sum');
    }
}
