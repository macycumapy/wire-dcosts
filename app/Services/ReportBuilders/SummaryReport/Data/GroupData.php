<?php

declare(strict_types=1);

namespace App\Services\ReportBuilders\SummaryReport\Data;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class GroupData extends Data
{
    #[Computed]
    public float $sum;

    public function __construct(
        public string $group_type,
        public Collection $items,
    ) {
        $this->sum = $items->sum('sum');
    }
}
