<?php

declare(strict_types=1);

namespace App\Actions\Nomenclature;

use App\Actions\Nomenclature\Data\UpdateNomenclatureData;

class UpdateNomenclatureAction
{
    public function exec(UpdateNomenclatureData $data): bool
    {
        $nomenclature = $data->nomenclature;
        $nomenclature->name = $data->name;
        $nomenclature->nomenclatureType()->associate($data->nomenclature_type_id);
        $nomenclature->save();

        return $nomenclature->save();
    }
}
