<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CashFlowType;
use App\Models\Scopes\SampleByUser;
use App\Models\Traits\HasUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property CashFlowType $type
 * @mixin Builder
 */
class Category extends Model
{
    use HasFactory;
    use HasUser;

    public $timestamps = false;

    protected $casts = [
        'type' => CashFlowType::class,
    ];

    protected $fillable = [
        'name',
        'user_id',
        'type',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new SampleByUser());
    }
}
