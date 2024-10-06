<?php

declare(strict_types=1);

namespace App\Services\ReportBuilders\SummaryReport\Data;

use App\Enums\CashFlowType;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class MonthlyFlowsData extends Data
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
        public string $month,
        public Collection $items,
    ) {
        $this->inflowsSum = $items->where('type', CashFlowType::Inflow)->sum('sum');
        $this->outflowsSum = $items->where('type', CashFlowType::Outflow)->sum('sum');

        $this->sum = $this->inflowsSum + $this->outflowsSum;
        $this->percent = $this->inflowsSum > 0 ? 100 - abs(round($this->outflowsSum / $this->inflowsSum * 100)) : 0;
    }
}
