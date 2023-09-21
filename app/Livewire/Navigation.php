<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Report;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class Navigation extends Component
{
    public Collection $reports;

    protected $listeners = [
        'refresh-navigation-menu' => '$refresh',
    ];

    public function mount(): void
    {
        $this->reports = Report::all();
    }

    public function render(): View
    {
        return view('livewire.navigation');
    }
}
