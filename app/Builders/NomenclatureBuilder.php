<?php

declare(strict_types=1);

namespace App\Builders;

use App\Builders\Traits\SearchByName;
use App\Models\Nomenclature;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * @method searchByName(string $name)
 * @mixin Nomenclature
 */
class NomenclatureBuilder extends Builder
{
    use SearchByName;

    public function sortByLastUsed(): self
    {
        $sub = DB::table('cash_outflow_items')
            ->select([
                'nomenclature_id',
                DB::raw('max(id) as last_used_id')
            ])
            ->groupBy('nomenclature_id');

        return $this
            ->leftJoinSub($sub, 'coi', 'coi.nomenclature_id', '=', 'nomenclatures.id')
            ->orderByDesc('coi.last_used_id');
    }
}
