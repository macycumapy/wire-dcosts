<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\PartnerBuilder;
use App\Models\Scopes\SampleByUser;
use App\Models\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @mixin PartnerBuilder
 */
class Partner extends Model
{
    use HasFactory;
    use HasUser;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'user_id',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new SampleByUser());
    }

    public function newEloquentBuilder($query): PartnerBuilder
    {
        return new PartnerBuilder($query);
    }
}
