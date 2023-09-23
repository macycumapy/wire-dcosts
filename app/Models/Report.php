<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\ReportBuilder;
use App\Services\Enums\MetabaseSharedObjectType;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $slug
 * @property MetabaseSharedObjectType $object_type
 * @property int $object_id
 * @property string $name
 * @property array $params
 * @mixin ReportBuilder
 */
class Report extends Model
{
    public $timestamps = false;
    protected $casts = [
        'params' => 'array',
        'object_type' => MetabaseSharedObjectType::class,
    ];

    public function newEloquentBuilder($query): ReportBuilder
    {
        return new ReportBuilder($query);
    }
}
