<?php

declare(strict_types=1);

namespace App\Livewire\Widget;

use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Livewire\Component;

class ThemeWidget extends Component
{
    public const THEME_DARK = 'dark';

    public string $theme = self::THEME_DARK;
    public bool $isDark = true;

    public function mount(): void
    {
        $this->theme = Session::get('theme', self::THEME_DARK);
        $this->isDark = $this->theme === self::THEME_DARK;
    }

    public function updatedIsDark(): void
    {
        $this->theme = $this->isDark ? self::THEME_DARK : '';
        Session::put('theme', $this->theme);
        $this->js('window.location.reload()');
    }

    public function render(): View
    {
        return view('livewire.widget.theme-widget');
    }
}
