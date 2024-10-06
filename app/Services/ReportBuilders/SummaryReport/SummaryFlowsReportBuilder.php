<?php

declare(strict_types=1);

namespace App\Services\ReportBuilders\SummaryReport;

use App\Models\CashFlow;
use App\Services\ReportBuilders\SummaryReport\Data\FilterData;
use App\Services\ReportBuilders\SummaryReport\Data\GroupData;
use App\Services\ReportBuilders\SummaryReport\Data\MonthlyFlowsData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SummaryFlowsReportBuilder
{
    public function build(FilterData $data): Collection
    {
        $startBalance = CashFlow::balance($data->dateFrom ?? now()->startOfMillennium())
            ->addSelect([
                DB::raw("'Начальный остаток' as group_type"),
                DB::raw("1 as group_num"),
                DB::raw("null as type"),
                DB::raw("null as month"),
            ]);

        $endBalance = CashFlow::balance($data->dateTo)
            ->addSelect([
                DB::raw("'Конечный остаток' as group_type"),
                DB::raw("3 as group_num"),
                DB::raw("null as type"),
                DB::raw("null as month"),
            ]);

        $groupedData = CashFlow::balance()
            ->addSelect([
                DB::raw("'Движения' as group_type"),
                DB::raw("2 as group_num"),
                'type',
                DB::raw("to_char(date, 'YYYY-mm-01') as month")
            ])
            ->when(
                $data->dateFrom,
                fn (Builder $q) => $q->where('date', '>=', $data->dateFrom->startOfDay())
            )
            ->when(
                $data->dateTo,
                fn (Builder $q) => $q->where('date', '<=', $data->dateTo->endOfDay())
            )
            ->groupBy('type', 'month')
            ->union($startBalance)
            ->union($endBalance)
            ->orderBy('group_num')
            ->orderBy('month')
            ->orderBy('type')
            ->get()
            ->groupBy(['group_num']);

        return $this->asDataCollection($groupedData);
    }

    private function asDataCollection(Collection $collection): Collection
    {
        return $collection->map(function ($items, $key) {
            if (in_array($key, [1, 3], true)) {
                return $items->first();
            }

            return GroupData::from([
                'group_type' => 'Движения',
                'items' => $items->groupBy('month')->map(function ($items, $month) {
                    return MonthlyFlowsData::from([
                        'month' => Carbon::parse($month)->translatedFormat('F Y'),
                        'items' => $items
                    ]);
                }),
            ]);
        })->values();
    }
}
