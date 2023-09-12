<?php

declare(strict_types=1);

namespace App\Actions\Partner\Data;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class PartnerData extends Data
{
    public ?string $name;
    public int $user_id;

    public static function rules(ValidationContext $context): array
    {
        return [
            'user_id' => [
                'required',
                Rule::exists('users', 'id'),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('partners')->where('user_id', $context->payload['user_id']),
            ],
        ];
    }
}
