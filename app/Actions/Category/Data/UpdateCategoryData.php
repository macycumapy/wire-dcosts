<?php

declare(strict_types=1);

namespace App\Actions\Category\Data;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateCategoryData extends Data
{
    public Category $category;
    public string $name;

    public static function rules(ValidationContext $context): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')
                    ->where('user_id', $context->payload['user_id'])
                    ->whereNot('id', $context->payload['category']->id),
            ],
        ];
    }
}
