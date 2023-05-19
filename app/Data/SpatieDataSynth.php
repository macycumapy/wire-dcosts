<?php

declare(strict_types=1);

namespace App\Data;

use Livewire\Features\SupportWireables\WireableSynth;
use Spatie\LaravelData\Contracts\DataObject;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Resolvers\DataFromSomethingResolver;

class SpatieDataSynth extends WireableSynth
{
    public static $key = 'spatie_data';

    public static function match($target): bool
    {
        return $target instanceof DataObject || $target instanceof DataCollection;
    }

    public function get(&$target, $key): mixed
    {
        return data_get($target, $key);
    }

    public function set(&$target, $key, $value): void
    {
        data_set($target, $key, $value);
    }

    public function dehydrate($target, $dehydrateChild): array
    {
        return [$target->toArray(), ['class' => get_class($target)]];
    }

    public function hydrate($value, $meta, $hydrateChild)
    {
        return app(DataFromSomethingResolver::class)
            ->ignoreMagicalMethods('fromLivewire')
            ->execute($meta['class'], $value);
    }
}
