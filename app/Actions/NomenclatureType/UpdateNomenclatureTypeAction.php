<?php

declare(strict_types=1);

namespace App\Actions\NomenclatureType;

use App\Actions\NomenclatureType\Data\UpdateNomenclatureTypeData;

class UpdateNomenclatureTypeAction
{
    public function exec(UpdateNomenclatureTypeData $data): bool
    {
        $nomenclatureType = $data->nomenclatureType;
        $nomenclatureType->name = $data->name;
        $nomenclatureType->save();

        return $nomenclatureType->save();
    }
}
