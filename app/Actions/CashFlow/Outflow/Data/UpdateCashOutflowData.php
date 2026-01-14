<?php

declare(strict_types=1);

namespace App\Actions\CashFlow\Outflow\Data;

use App\Actions\CashOutflowItem\Data\OutflowItemData;
use App\Models\CashFlow;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Wireable;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateCashOutflowData extends Data implements Wireable
{
    use WireableData;

    #[Computed]
    public readonly float $sum;

    public function __construct(
        public CashFlow        $cashFlow,
        public Carbon          $date,
        public ?int            $category_id,
        #[DataCollectionOf(OutflowItemData::class)]
        public ?DataCollection $details,
        public ?int            $account_id,
    ) {
        $this->sum = $this->details->toCollection()->sum('sum');
    }

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
            'account_id' => [
                'required',
                Rule::exists('accounts', 'id')
                    ->where('user_id', data_get($context->payload, 'cashFlow')?->user_id)
            ],
            'details' => ['required', 'array', 'min:1']
        ];
    }
}
