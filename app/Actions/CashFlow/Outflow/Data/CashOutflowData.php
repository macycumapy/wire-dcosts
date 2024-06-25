<?php

declare(strict_types=1);

namespace App\Actions\CashFlow\Outflow\Data;

use App\Actions\CashOutflowItem\Data\OutflowItemData;
use App\Enums\CashFlowType;
use App\Models\CashFlow;
use App\Models\CashOutflowItem;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CashOutflowData extends Data
{
    public float $sum;
    public readonly CashFlowType $type;

    public function __construct(
        public Carbon|string|null $date,
        public int $user_id,
        public ?int $category_id,
        public ?int $account_id,
        #[DataCollectionOf(OutflowItemData::class)]
        public ?DataCollection $details,
    ) {
        $this->refreshSum();
        $this->type = CashFlowType::Outflow;
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'user_id' => ['required', Rule::exists('users', 'id')],
            'date' => ['required', 'date'],
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')
                    ->where('type', data_get($context->payload, 'type'))
                    ->where('user_id', data_get($context->payload, 'user_id'))
            ],
            'account_id' => [
                'required',
                Rule::exists('accounts', 'id')
                    ->where('user_id', data_get($context->payload, 'user_id'))
            ],
            'details' => ['required', 'array', 'min:1']
        ];
    }

    public static function createFromCashFlow(CashFlow $cashFlow): static
    {
        return static::from([
            ...$cashFlow->toArray(),
            'details' => $cashFlow->details->map(fn (CashOutflowItem $item) => [
                ...$item->toArray(),
                'user_id' => $cashFlow->user_id,
            ])
        ]);
    }

    public function refreshSum(): void
    {
        $this->sum = $this->details?->toCollection()->sum('sum') ?? 0.0;
    }
}
