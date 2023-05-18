<?php

declare(strict_types=1);

namespace App\Data\Casts;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class TrimCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $context): ?string
    {
        if (is_string($value)) {
            return trim($value);
        }

        return $value;
    }
}
