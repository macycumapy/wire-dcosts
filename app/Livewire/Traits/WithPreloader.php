<?php

declare(strict_types=1);

namespace App\Livewire\Traits;

trait WithPreloader
{
    public function showPreloader(): void
    {
        $this->dispatch('show-preloader');
    }

    public function redirectWithPreloader(string $route, bool $navigate = true): void
    {
        $this->redirectRoute($route, navigate: $navigate);
        $this->showPreloader();
    }
}
