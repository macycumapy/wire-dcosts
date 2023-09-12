<?php

declare(strict_types=1);

namespace App\Enums\Traits;

trait WithValues
{
    public static function values(): array
    {
        return array_map(static fn (self $item) => $item->value, self::cases());
    }
}
