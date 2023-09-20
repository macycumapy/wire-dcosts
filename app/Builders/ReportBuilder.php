<?php

declare(strict_types=1);

namespace App\Builders;

use App\Models\Report;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Report
 */
class ReportBuilder extends Builder
{
    public function findBySlugOrFail(string $slug): Report
    {
        return $this->where('slug', $slug)->firstOrFail();
    }
}
