<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SampleByUser implements Scope
{
    public function apply(Builder $builder, Model $model): Builder
    {
        if (auth()->check()) {
            return $builder->where('user_id', auth()->id());
        }

        return $builder;
    }
}
