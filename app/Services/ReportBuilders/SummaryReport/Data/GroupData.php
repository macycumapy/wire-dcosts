<?php

declare(strict_types=1);

namespace App\Services\ReportBuilders\SummaryReport\Data;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

class GroupData extends Data
{
    #[Computed]
    public float $sum;
    #[Computed]
    public float $inflowsSum;
    #[Computed]
    public float $outflowsSum;
    #[Computed]
    public float $percent;

    public function __construct(
        public string $group_type,
        #[DataCollectionOf(MonthlyFlowsData::class)]
        public Collection $items,
    ) {
        $this->sum = $items->sum('sum');
        $inflows = $items->sum('inflowsSum');
        $outflows = $items->sum('outflowsSum');

        $this->percent = $inflows > 0 ? 100 - abs(round($outflows / $inflows * 100)) : 0;
    }
}
