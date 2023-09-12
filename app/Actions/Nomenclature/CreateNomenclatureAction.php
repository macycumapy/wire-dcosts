<?php

declare(strict_types=1);

namespace App\Actions\Nomenclature;

use App\Actions\Nomenclature\Data\NomenclatureData;
use App\Models\Nomenclature;

class CreateNomenclatureAction
{
    public function exec(NomenclatureData $data): Nomenclature
    {
        return Nomenclature::create($data->toArray());
    }
}
