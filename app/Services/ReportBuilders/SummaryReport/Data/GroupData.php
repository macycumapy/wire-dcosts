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
        $this->inflowsSum = $items->sum('inflowsSum');
        $this->outflowsSum = $items->sum('outflowsSum');

        $this->percent = $this->inflowsSum > 0 ? 100 - abs(round($this->outflowsSum / $this->inflowsSum * 100)) : 0;
    }
}
