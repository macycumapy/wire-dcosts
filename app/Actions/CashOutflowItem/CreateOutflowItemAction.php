<?php

declare(strict_types=1);

namespace App\Actions\CashOutflowItem;

use App\Actions\CashOutflowItem\Data\OutflowItemData;
use App\Models\CashFlow;
use App\Models\CashOutflowItem;

class CreateOutflowItemAction
{
    public function exec(CashFlow $cashFlow, OutflowItemData $data): CashOutflowItem
    {
        $details = new CashOutflowItem();
        $details->count = $data->count;
        $details->cost = $data->cost;
        $details->comment = $data->comment;
        $details->nomenclature()->associate($data->nomenclature_id);
        $details->cashFlow()->associate($cashFlow);
        $details->save();

        return $details;
    }
}
