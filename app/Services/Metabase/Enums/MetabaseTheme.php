<?php

declare(strict_types=1);

namespace App\Services\Metabase\Enums;

enum MetabaseTheme: string
{
    case Dark = 'night';
    case Light = 'light';
    case Transparent = 'transparent';
}
