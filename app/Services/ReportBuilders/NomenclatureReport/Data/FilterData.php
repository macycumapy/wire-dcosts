<?php

declare(strict_types=1);

namespace App\Services\ReportBuilders\NomenclatureReport\Data;

use App\Models\User;
use Carbon\Carbon;
use Spatie\LaravelData\Data;

class FilterData extends Data
{
    public User $user;
    public int $nomenclatureId;
    public ?Carbon $dateFrom = null;
    public ?Carbon $dateTo = null;
    public ?int $categoryId = null;
}
