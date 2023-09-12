<?php

declare(strict_types=1);

namespace App\Actions\Nomenclature\Data;

use App\Models\Nomenclature;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateNomenclatureData extends Data
{
    public Nomenclature $nomenclature;
    public string $name;
    public ?int $nomenclature_type_id = null;

    public static function rules(ValidationContext $context): array
    {
        return [
            'nomenclature_type_id' => [
                'int',
                'nullable',
                Rule::exists('nomenclature_types', 'id'),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('nomenclatures')
                    ->where('user_id', $context->payload['nomenclature']->user_id)
                    ->where('nomenclature_type_id', $context->payload['nomenclature_type_id'])
                    ->whereNot('id', $context->payload['nomenclature']->id),
            ],
        ];
    }
}
