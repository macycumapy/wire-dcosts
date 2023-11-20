<?php

declare(strict_types=1);

namespace App\Services\ReportBuilders\OutflowsReport;

use App\Enums\CashFlowType;
use App\Services\ReportBuilders\OutflowsReport\Data\FilterData;
use App\Services\ReportBuilders\OutflowsReport\Data\GroupData;
use App\Services\ReportBuilders\OutflowsReport\Data\OutflowData;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OutflowsReportBuilder
{
    public function build(FilterData $data): Collection
    {
        $groupedData = DB::table('cash_outflow_items as coi')
            ->select(
                DB::raw('sum(round(coi.count::numeric * coi.cost::numeric, 2)) as sum'),
                DB::raw('COALESCE(ci.name, \'Прочее\') as category'),
                DB::raw('COALESCE(nt.name, \'Прочее\') as nomenclature_type'),
                'n.name as nomenclature',
                'n.id as nomenclature_id',
                'ci.id as category_id',
            )
            ->leftJoin('nomenclatures as n', 'n.id', '=', 'coi.nomenclature_id')
            ->leftJoin('cash_flows as cf', 'cf.id', '=', 'coi.cash_flow_id')
            ->leftJoin('categories as ci', 'ci.id', '=', 'cf.category_id')
            ->leftJoin('nomenclature_types as nt', 'nt.id', '=', 'n.nomenclature_type_id')
            ->when(
                $data->dateFrom,
                fn (Builder $q) => $q->where('cf.date', '>=', $data->dateFrom->timezone($data->user->timezone)->startOfDay())
            )
            ->when(
                $data->dateTo,
                fn (Builder $q) => $q->where('cf.date', '<=', $data->dateTo->timezone($data->user->timezone)->endOfDay())
            )
            ->whereNull('cf.deleted_at')
            ->where('cf.type', CashFlowType::Outflow)
            ->where('cf.user_id', $data->user->id)
            ->groupBy('category', 'nomenclature', 'nomenclature_type', 'n.id', 'ci.id')
            ->orderByDesc('sum')
            ->get()
            ->groupBy(['category', fn ($item) => $item->nomenclature_type]);

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

            return OutflowData::from($item);
        })->sortByDesc('sum')->values();
    }
}
