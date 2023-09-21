<?php

declare(strict_types=1);

namespace App\Services\InitialBalances\Data;

use Spatie\LaravelData\Data;

class OutflowDetailsData extends Data
{
    public ?string $nomenclatureName = null;
    public ?string $nomenclatureType = null;
    public ?string $comment = null;
    public ?float $count = null;
    public ?float $cost = null;
    public ?int $nomenclature_id = null;
}
