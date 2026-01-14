<?php

declare(strict_types=1);

namespace App\Actions\Category\Data;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateCategoryData extends Data implements Wireable
{
    use WireableData;

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
                    ->where('user_id', data_get($context->payload, 'category.user_id'))
                    ->where('type', data_get($context->payload, 'category.type'))
                    ->ignore(data_get($context->payload, 'category')),
            ],
        ];
    }
}
