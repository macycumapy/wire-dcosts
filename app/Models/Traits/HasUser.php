<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $user_id Идентификатор пользователя
 * @property-read User $user Пользователь-владелец
 */
trait HasUser
{
    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param Builder $query
     * @param User $user
     * @return Builder
     */
    public function scopeOfUser(Builder $query, User $user): Builder
    {
        return $query->where('user_id', $user->id);
    }
}
