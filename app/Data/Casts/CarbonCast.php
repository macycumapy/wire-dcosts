<?php

declare(strict_types=1);

namespace App\Data\Casts;

use Carbon\Carbon;
use DateTimeInterface;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;
use Throwable;

class CarbonCast implements Cast
{
    public function __construct(
        protected null|string|array $format = null,
        protected ?string $type = null,
        protected ?string $setTimeZone = null,
        protected ?string $timeZone = null
    ) {
    }

    public function cast(DataProperty $property, mixed $value, array $context): ?DateTimeInterface
    {
        try {
            return Carbon::make($value);
        } catch (Throwable) {
            return null;
        }
    }
}
