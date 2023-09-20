<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\ReportBuilder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $slug
 * @property int $question_id
 * @property string $name
 * @property array $params
 * @mixin ReportBuilder
 */
class Report extends Model
{
    public $timestamps = false;
    protected $casts = [
        'params' => 'array',
    ];

    public function newEloquentBuilder($query): ReportBuilder
    {
        return new ReportBuilder($query);
    }
}
