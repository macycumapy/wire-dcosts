<?php

declare(strict_types=1);

namespace App\Services\ReportBuilders\OutflowsReport\Data;

use App\Models\User;
use Carbon\Carbon;
use Spatie\LaravelData\Data;

class FilterData extends Data
{
    public User $user;
    public ?Carbon $dateFrom = null;
    public ?Carbon $dateTo = null;
}
