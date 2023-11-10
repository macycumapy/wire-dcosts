<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\WithTitles;
use Carbon\Carbon;

enum Period: string
{
    use WithTitles;

    case Day = 'today';
    case Week = 'week';
    case Month = 'month';
    case Year = 'year';
    case AllTime = 'all';
    case Custom = 'custom';

    public function title(): string
    {
        return match ($this) {
            self::Day => 'Сегодня',
            self::Week => 'Эта неделя',
            self::Month => 'Этот месяц',
            self::Year => 'Этот год',
            self::AllTime => 'Все время',
            self::Custom => 'Произвольный период',
        };
    }

    public function dateFrom(): ?Carbon
    {
        $date = now();
        return match ($this) {
            self::Day => $date->startOfDay(),
            self::Week => $date->startOfWeek(),
            self::Month => $date->startOfMonth(),
            self::Year => $date->startOfYear(),
            default => null,
        };
    }

    public function dateTo(): ?Carbon
    {
        $date = now();
        return match ($this) {
            self::Day => $date->endOfDay(),
            self::Week => $date->endOfWeek(),
            self::Month => $date->endOfMonth(),
            self::Year => $date->endOfYear(),
            default => null,
        };
    }
}
