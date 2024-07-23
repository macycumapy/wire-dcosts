<?php

declare(strict_types=1);

namespace App\Actions\NomenclatureType\Data;

use App\Models\NomenclatureType;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateNomenclatureTypeData extends Data
{
    public NomenclatureType $nomenclatureType;
    public string $name;

    public static function rules(ValidationContext $context): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('nomenclature_types')
                    ->where('user_id', data_get($context->payload, 'nomenclatureType.user_id'))
                    ->ignore(data_get($context->payload, 'nomenclatureType')),
            ],
        ];
    }
}
