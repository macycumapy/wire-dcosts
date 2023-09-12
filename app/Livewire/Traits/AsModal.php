<?php

declare(strict_types=1);

namespace App\Livewire\Traits;

trait AsModal
{
    public bool $showModal = false;

    public function closeModal(): void
    {
        $this->showModal = false;
    }
}
