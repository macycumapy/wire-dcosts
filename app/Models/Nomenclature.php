<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\NomenclatureBuilder;
use App\Models\Scopes\SampleByUser;
use App\Models\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property int|null $nomenclature_type_id
 * @property-read NomenclatureType $nomenclatureType
 * @mixin NomenclatureBuilder
 */
class Nomenclature extends Model
{
    use HasFactory;
    use HasUser;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'user_id',
        'nomenclature_type_id',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new SampleByUser());
    }

    public function newEloquentBuilder($query): NomenclatureBuilder
    {
        return new NomenclatureBuilder($query);
    }

    /**
     * Тип номенклатуры
     *
     * @return BelongsTo
     */
    public function nomenclatureType(): BelongsTo
    {
        return $this->belongsTo(NomenclatureType::class);
    }
}
