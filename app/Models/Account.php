<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\AccountBuilder;
use App\Models\Scopes\SampleByUser;
use App\Models\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string|null $comment
 * @property float $balance
 * @property bool $is_main
 * @mixin AccountBuilder
 */
class Account extends Model
{
    use HasFactory;
    use HasUser;
    use SoftDeletes;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'comment',
    ];

    protected $casts = [
        'balance' => 'float',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new SampleByUser());
    }

    public function newEloquentBuilder($query): AccountBuilder
    {
        return new AccountBuilder($query);
    }
}
