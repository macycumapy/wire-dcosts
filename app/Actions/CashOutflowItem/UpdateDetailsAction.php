<?php

declare(strict_types=1);

namespace App\Actions\CashOutflowItem;

use App\Actions\CashOutflowItem\Data\OutflowItemData;
use App\Models\CashOutflowItem;

class UpdateDetailsAction
{
    public function exec(CashOutflowItem $outflowItem, OutflowItemData $data): bool
    {
        $outflowItem->count = $data->count;
        $outflowItem->cost = $data->cost;
        $outflowItem->comment = $data->comment;
        $outflowItem->nomenclature()->associate($data->nomenclature_id);

        return $outflowItem->save();
    }
}
