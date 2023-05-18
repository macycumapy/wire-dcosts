<?php

declare(strict_types=1);

namespace App\WireUI;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class Input extends \WireUi\View\Components\Input
{
    protected function getDefaultColorClasses(): string
    {
        return Str::of('placeholder-secondary-400')
            ->unless($this->borderless, function (Stringable $stringable) {
                return $stringable
                    ->append(' border border-secondary-300 focus:border-emerald-800 focus:ring-emerald-800');
            })->toString();
    }

    protected function getErrorClasses(): string
    {
        return Str::of('text-negative-900')
            ->unless($this->borderless, function (Stringable $stringable) {
                return $stringable
                    ->append(' border border-negative-300 focus:ring-negative-500 focus:border-negative-500');
            })->toString();
    }

    protected function getDefaultClasses(): string
    {
        return Str::of('form-input block w-full sm:text-sm rounded-md transition ease-in-out duration-100 focus:outline-none')
            ->when($this->borderless, function (Stringable $stringable) {
                return $stringable->append(' border-transparent focus:border-transparent focus:ring-transparent');
            })->toString();
    }
}
