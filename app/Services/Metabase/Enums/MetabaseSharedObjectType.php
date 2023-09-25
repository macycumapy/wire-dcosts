<?php

declare(strict_types=1);

namespace App\Services\Metabase\Enums;

enum MetabaseSharedObjectType: string
{
    case Dashboard = 'dashboard';
    case Question = 'question';
}
