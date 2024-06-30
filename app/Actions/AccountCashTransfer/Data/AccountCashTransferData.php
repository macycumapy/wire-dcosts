<?php

declare(strict_types=1);

namespace App\Actions\AccountCashTransfer\Data;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class AccountCashTransferData extends Data
{
    public int $user_id;
    public ?float $sum = null;
    public ?int $from_account_id = null;
    public ?int $to_account_id = null;

    public static function rules(ValidationContext $context): array
    {
        return [
            'user_id' => ['required', Rule::exists('users', 'id')],
            'sum' => ['required', 'numeric', 'between:1,9999999.99'],
            'from_account_id' => ['required', 'different:to_account_id', Rule::exists('accounts', 'id')
                ->where('user_id', data_get($context->payload, 'user_id'))],
            'to_account_id' => ['required', 'different:from_account_id', Rule::exists('accounts', 'id')
                ->where('user_id', data_get($context->payload, 'user_id'))],
        ];
    }
}
