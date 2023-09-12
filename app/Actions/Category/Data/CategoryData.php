<?php

declare(strict_types=1);

namespace App\Actions\Category\Data;

use App\Enums\CashFlowType;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CategoryData extends Data
{
    public int $user_id;
    public CashFlowType|string|null $type = null;
    public ?string $name = null;

    public static function rules(ValidationContext $context): array
    {
        return [
            'user_id' => [
                'required',
                Rule::exists('users', 'id'),
            ],
            'type' => [
                'required',
                'string',
                Rule::in(CashFlowType::values())
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')
                    ->where('type', $context->payload['type'])
                    ->where('user_id', $context->payload['user_id']),
            ],
        ];
    }
}
