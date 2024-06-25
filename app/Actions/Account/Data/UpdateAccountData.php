<?php

declare(strict_types=1);

namespace App\Actions\Account\Data;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateAccountData extends Data
{
    public ?int $id = null;
    public ?int $user_id = null;
    public ?string $name = null;
    public ?string $comment = null;

    public static function rules(ValidationContext $context): array
    {
        return [
            'id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'name' => ['required','string','max:255', Rule::unique('accounts')
                ->where('user_id', data_get($context->payload, 'user_id'))
                ->ignore(data_get($context->payload, 'id'))
            ],
            'comment' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }
}
