<?php

declare(strict_types=1);

namespace App\Livewire\Traits;

trait WithDisabledButtons
{
    public bool $disabledButtons = false;

    public function disableButtons(): void
    {
        $this->disabledButtons = true;
    }
}
