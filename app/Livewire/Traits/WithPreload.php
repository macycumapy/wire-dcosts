<?php

declare(strict_types=1);

namespace App\Livewire\Traits;

use Livewire\Attributes\Url;

trait WithPreload
{
    #[Url]
    public bool $preload = true;
}
