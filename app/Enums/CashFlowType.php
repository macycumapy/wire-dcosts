<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\WithTitles;

enum CashFlowType: string
{
    use WithTitles;

    case Inflow = 'inflow';
    case Outflow = 'outflow';

    public function title(): string
    {
        return match ($this) {
            self::Inflow => 'Приход',
            self::Outflow => 'Расход',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Inflow => 'positive',
            self::Outflow => 'negative',
        };
    }

    public function textColorStyle(): string
    {
        return match ($this) {
            self::Outflow => "text-{$this->color()}-400",
            default => "text-{$this->color()}-600",
        };
    }
}
