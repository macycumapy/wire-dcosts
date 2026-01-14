<?php

declare(strict_types=1);

namespace App\Actions\CashOutflowItem\Data;

use Illuminate\Validation\Rule;
use Livewire\Wireable;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class OutflowItemData extends Data implements Wireable
{
    use WireableData;

    #[Computed]
    public readonly float $sum;

    public function __construct(
        public ?int    $user_id,
        public ?float  $count,
        public ?float  $cost,
        public ?int    $nomenclature_id = null,
        public ?int    $id = null,
        public ?string $comment = null,
    ) {
        $this->sum = $this->cost * $this->count;
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'count' => ['required', 'numeric'],
            'cost' => ['required', 'numeric'],
            'user_id' => ['required', Rule::exists('users', 'id')],
            'nomenclature_id' => [
                'required',
                Rule::exists('nomenclatures', 'id')
                    ->where('user_id', $context->payload['user_id'])
            ],
            'comment' => ['nullable', 'string', 'max:255']
        ];
    }

    public function copy(): self
    {
        return self::from([
            ...$this->toArray(),
            'id' => null,
        ]);
    }
}
