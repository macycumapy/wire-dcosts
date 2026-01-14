<?php

declare(strict_types=1);

namespace App\Actions\Partner\Data;

use App\Models\Partner;
use Illuminate\Validation\Rule;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdatePartnerData extends Data implements Wireable
{
    use WireableData;

    public Partner $partner;
    public string $name;

    public static function rules(ValidationContext $context): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('partners')
                    ->where('user_id', data_get($context->payload, 'partner.user_id'))
                    ->ignore(data_get($context->payload, 'partner'))
            ],
        ];
    }
}
