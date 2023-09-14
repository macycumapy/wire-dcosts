<?php

declare(strict_types=1);

namespace App\Actions\CashFlow\Data;

use App\Models\CashFlow;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateCashFlowData extends Data
{
    public CashFlow $cashFlow;
    public Carbon|string $date;
    public float $sum;
    public ?int $category_id;
    public ?int $partner_id;

    public static function rules(ValidationContext $context): array
    {
        return [
            'sum' => ['required', 'numeric', 'min:0'],
            'date' => ['required', 'date'],
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')
                    ->where('type', $context->payload['cashFlow']->type)
                    ->where('user_id', $context->payload['cashFlow']->user_id)
            ],
            'partner_id' => [
                'required',
                Rule::exists('partners', 'id')
                    ->where('user_id', $context->payload['cashFlow']->user_id)
            ],
        ];
    }
}
