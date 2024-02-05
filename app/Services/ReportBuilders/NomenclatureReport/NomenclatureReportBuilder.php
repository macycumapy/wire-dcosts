<?php

declare(strict_types=1);

namespace App\Services\ReportBuilders\NomenclatureReport;

use App\Services\ReportBuilders\NomenclatureReport\Data\FilterData;
use App\Services\ReportBuilders\NomenclatureReport\Data\NomenclatureData;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class NomenclatureReportBuilder
{
    public function build(FilterData $data): DataCollection
    {
        $result = DB::table('cash_outflow_items as coi')
            ->select(
                DB::raw('round(coi.count::numeric * coi.cost::numeric, 2) as sum'),
                'n.name as nomenclature_name',
                'coi.cash_flow_id',
                'cf.date',
            )
            ->leftJoin('nomenclatures as n', 'n.id', '=', 'coi.nomenclature_id')
            ->leftJoin('cash_flows as cf', 'cf.id', '=', 'coi.cash_flow_id')
            ->leftJoin('categories as ci', 'ci.id', '=', 'cf.category_id')
            ->whereNull('cf.deleted_at')
            ->when(
                $data->dateFrom,
                fn (Builder $q) => $q->where('cf.date', '>=', $data->dateFrom->timezone($data->user->timezone)->startOfDay())
            )
            ->when(
                $data->dateTo,
                fn (Builder $q) => $q->where('cf.date', '<=', $data->dateTo->timezone($data->user->timezone)->endOfDay())
            )
            ->when(
                $data->categoryId,
                fn (Builder $q) => $q->where('cf.category_id', $data->categoryId)
            )
            ->where('n.id', $data->nomenclatureId)
            ->where('cf.user_id', $data->user->id)
            ->orderByDesc('cf.date')
            ->get();

        return new DataCollection(NomenclatureData::class, $result);
    }
}
