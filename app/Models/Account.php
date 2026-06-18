<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\AccountBuilder;
use App\Models\Scopes\SampleByUser;
use App\Models\Traits\HasUser;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string|null $comment
 * @property float $balance
 * @property bool $is_main
 * @property bool $hidden
 * @mixin AccountBuilder
 */
#[UseEloquentBuilder(AccountBuilder::class)]
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
        'is_main' => 'boolean',
        'hidden' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new SampleByUser());
    }
}
