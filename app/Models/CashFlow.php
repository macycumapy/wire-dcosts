<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\CashFlowBuilder;
use App\Enums\CashFlowType;
use App\Models\Scopes\SampleByUser;
use App\Models\Traits\HasUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Движение денежных средств
 *
 * @property int $id
 * @property float $sum Сумма движения
 * @property Carbon $date Дата движения
 * @property Carbon $created_at Дата создания
 * @property Carbon $updated_at Дата обновления
 * @property Carbon $deleted_at Дата удаления
 * @property int|null $category_id ID статьи затрат
 * @property int|null $partner_id ID контрагента
 * @property int $account_id ID счета
 * @property CashFlowType $type Тип движения
 * @property-read Category|null $category Статья затрат
 * @property-read Partner|null $partner Контрагент
 * @property-read Collection<CashOutflowItem> $details
 * @property-read Account $account
 * @mixin CashFlowBuilder
 */
class CashFlow extends Model
{
    use HasFactory;
    use HasUser;
    use SoftDeletes;

    protected $casts = [
        'sum' => 'float',
        'type' => CashFlowType::class,
        'date' => 'datetime'
    ];

    public $fillable = [
        'sum',
        'date',
        'category_id',
        'partner_id',
        'type',
        'user_id',
        'account_id',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new SampleByUser());
    }

    public function newEloquentBuilder($query): CashFlowBuilder
    {
        return new CashFlowBuilder($query);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(CashOutflowItem::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function isOutflow(): bool
    {
        return $this->type === CashFlowType::Outflow;
    }
}
