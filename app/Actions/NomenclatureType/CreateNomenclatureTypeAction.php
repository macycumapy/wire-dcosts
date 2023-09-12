<?php

declare(strict_types=1);

namespace App\Actions\NomenclatureType;

use App\Actions\NomenclatureType\Data\NomenclatureTypeData;
use App\Models\NomenclatureType;

class CreateNomenclatureTypeAction
{
    public function exec(NomenclatureTypeData $data): NomenclatureType
    {
        return NomenclatureType::create($data->toArray());
    }
}
