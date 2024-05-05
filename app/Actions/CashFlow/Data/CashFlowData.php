<?php

declare(strict_types=1);

namespace App\Actions\CashFlow\Data;

use App\Enums\CashFlowType;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CashFlowData extends Data
{
    public Carbon|string|null $date;
    public float $sum;
    public int $user_id;
    public CashFlowType|string|null $type;
    public ?int $category_id;
    public ?int $partner_id;
    public int $account_id;

    public static function rules(ValidationContext $context): array
    {
        return [
            'user_id' => ['required', Rule::exists('users', 'id')],
            'sum' => ['required', 'numeric', 'min:0'],
            'date' => ['required', 'date'],
            'type' => ['required', 'string', Rule::in(CashFlowType::values())],
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')
                    ->where('type', $context->payload['type'])
                    ->where('user_id', $context->payload['user_id'])
            ],
            'partner_id' => [
                'required',
                Rule::exists('partners', 'id')
                    ->where('user_id', $context->payload['user_id'])
            ],
            'account_id' => [
                'required',
                Rule::exists('accounts', 'id')
                    ->where('user_id', $context->payload['user_id'])
            ],
        ];
    }
}
