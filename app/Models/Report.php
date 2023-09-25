<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\ReportBuilder;
use App\Services\Metabase\Enums\MetabaseSharedObjectType;
use App\Services\Metabase\Enums\MetabaseTheme;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $slug
 * @property MetabaseSharedObjectType $object_type
 * @property int $object_id
 * @property string $name
 * @property array $params
 * @property MetabaseTheme $theme
 * @mixin ReportBuilder
 */
class Report extends Model
{
    public $timestamps = false;
    protected $casts = [
        'params' => 'array',
        'object_type' => MetabaseSharedObjectType::class,
        'theme' => MetabaseTheme::class,
    ];

    public function newEloquentBuilder($query): ReportBuilder
    {
        return new ReportBuilder($query);
    }
}
