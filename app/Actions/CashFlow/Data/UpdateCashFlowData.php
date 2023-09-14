<?php

declare(strict_types=1);

namespace App\Actions\CashFlow\Data;

use App\Models\CashFlow;
use Carbon\Carbon;
use Spatie\LaravelData\Data;

class UpdateCashFlowData extends Data
{
    public CashFlow $cashFlow;
    public Carbon $date;
    public float $sum;
    public ?int $category_id;
    public ?int $partner_id;
}
