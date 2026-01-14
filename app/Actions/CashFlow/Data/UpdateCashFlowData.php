<?php

declare(strict_types=1);

namespace App\Actions\CashFlow\Data;

use App\Models\CashFlow;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateCashFlowData extends Data implements Wireable
{
    use WireableData;

    public CashFlow $cashFlow;
    public Carbon|string $date;
    public float $sum;
    public ?int $category_id;
    public ?int $partner_id;
    public int $account_id;

    public static function rules(ValidationContext $context): array
    {
        return [
            'sum' => ['required', 'numeric', 'min:0'],
            'date' => ['required', 'date'],
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')
                    ->where('type', data_get($context->payload, 'cashFlow')?->type)
                    ->where('user_id', data_get($context->payload, 'cashFlow')?->user_id)
            ],
            'partner_id' => [
                'required',
                Rule::exists('partners', 'id')
                    ->where('user_id', data_get($context->payload, 'cashFlow')?->user_id)
            ],
            'account_id' => [
                'required',
                Rule::exists('accounts', 'id')
                    ->where('user_id', data_get($context->payload, 'cashFlow')?->user_id)
            ],
        ];
    }
}
