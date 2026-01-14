<?php

declare(strict_types=1);

namespace App\Actions\Account\Data;

use Illuminate\Validation\Rule;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class AccountData extends Data implements Wireable
{
    use WireableData;

    public int $user_id;
    public ?string $name = null;
    public ?string $comment = null;
    public ?float $balance = null;

    public static function rules(ValidationContext $context): array
    {
        return [
            'user_id' => ['required', Rule::exists('users', 'id')],
            'name' => ['required','string','max:255', Rule::unique('accounts')
                ->where('user_id', $context->payload['user_id'])
            ],
            'comment' => ['sometimes', 'nullable', 'string', 'max:255'],
            'balance' => ['required', 'numeric', 'min:0', 'max:99999999'],
        ];
    }
}
