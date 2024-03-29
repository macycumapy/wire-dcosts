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
            self::Inflow => 'Поступление',
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
}
