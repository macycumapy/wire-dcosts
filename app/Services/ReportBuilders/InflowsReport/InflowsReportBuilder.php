<?php

declare(strict_types=1);

namespace App\Services\ReportBuilders\InflowsReport;

use App\Enums\CashFlowType;
use App\Services\ReportBuilders\InflowsReport\Data\FilterData;
use App\Services\ReportBuilders\InflowsReport\Data\GroupData;
use App\Services\ReportBuilders\InflowsReport\Data\InflowData;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class InflowsReportBuilder
{
    public function build(FilterData $data): Collection
    {
        $groupedData = DB::table('cash_flows as cf')
            ->select(
                DB::raw('sum(cf.sum) as sum'),
                DB::raw('COALESCE(ci.name, \'Прочее\') as category'),
                DB::raw('COALESCE(p.name, \'Прочее\') as partner'),
                'ci.id as category_id',
            )
            ->leftJoin('categories as ci', 'ci.id', 'cf.category_id')
            ->leftJoin('partners as p', 'p.id', 'cf.partner_id')
            ->when(
                $data->dateFrom,
                fn (Builder $q) => $q->where('cf.date', '>=', $data->dateFrom->timezone($data->user->timezone)->startOfDay())
            )
            ->when(
                $data->dateTo,
                fn (Builder $q) => $q->where('cf.date', '<=', $data->dateTo->timezone($data->user->timezone)->endOfDay())
            )
            ->whereNull('cf.deleted_at')
            ->where('cf.type', CashFlowType::Inflow)
            ->where('cf.user_id', $data->user->id)
            ->groupBy('partner', 'category', 'ci.id')
            ->orderByDesc('sum')
            ->get()
            ->groupBy(['partner', 'category']);

        return $this->asDataCollection($groupedData);
    }

    private function asDataCollection(Collection $collection): Collection
    {
        return $collection->map(function ($item, $key) {
            if ($item instanceof Collection) {
                $details = $this->asDataCollection($item);

                return GroupData::from([
                    'name' => $key,
                    'details' => $details,
                ]);
            }

            return InflowData::from($item);
        })->sortByDesc('sum')->values();
    }
}
