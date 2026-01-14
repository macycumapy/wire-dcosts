<?php

declare(strict_types=1);

namespace App\Actions\Nomenclature\Data;

use Illuminate\Validation\Rule;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class NomenclatureData extends Data implements Wireable
{
    use WireableData;

    public int $user_id;
    public ?string $name = null;
    public ?int $nomenclature_type_id = null;

    public static function rules(ValidationContext $context): array
    {
        return [
            'user_id' => [
                'required',
                Rule::exists('users', 'id'),
            ],
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
                    ->where('user_id', $context->payload['user_id'])
                    ->where('nomenclature_type_id', $context->payload['nomenclature_type_id']),
            ],
        ];
    }
}
