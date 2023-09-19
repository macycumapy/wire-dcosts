<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property float $count Количество номенклатуры
 * @property float $cost Стоимость номенклатуры
 * @property int $cash_outflow_id ID расхода
 * @property int $nomenclature_id ID номенклатуры
 * @property string|null $comment Комментарий
 * @property-read CashFlow $cashFlow Расход денежных средств
 * @property-read Nomenclature $nomenclature Номенклатура
 * @property-read float $sum Сумма
 * @mixin Builder
 */
class CashOutflowItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'count',
        'cost',
        'nomenclature_id',
        'comment',
    ];

    /**
     * Расход денежных средств
     * @return BelongsTo
     */
    public function cashFlow(): BelongsTo
    {
        return $this->belongsTo(CashFlow::class);
    }

    /**
     * Номенклатура
     * @return BelongsTo
     */
    public function nomenclature(): BelongsTo
    {
        return $this->belongsTo(Nomenclature::class);
    }

    /**
     * Сумма
     * @return float
     */
    public function getSumAttribute(): float
    {
        return round($this->count * $this->cost, 2);
    }
}
