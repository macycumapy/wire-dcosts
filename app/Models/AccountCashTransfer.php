<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\SampleByUser;
use App\Models\Traits\HasUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $from_account_id
 * @property int $to_account_id
 * @property float $sum
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Account $fromAccount
 * @property-read Account $toAccount
 * @mixin Builder
 */
class AccountCashTransfer extends Model
{
    use HasFactory;
    use HasUser;
    use SoftDeletes;

    protected $fillable = [
        'sum',
    ];

    protected $casts = [
        'sum' => 'float',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new SampleByUser());
    }

    public function fromAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'from_account_id');
    }

    public function toAccount(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'to_account_id');
    }
}
