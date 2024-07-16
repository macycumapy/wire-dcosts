<?php

declare(strict_types=1);

namespace App\Providers;

use App\Data\SpatieDataSynth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->isProduction()) {
            URL::forceScheme('https');
        }

        Model::shouldBeStrict(!$this->app->isProduction());

        Livewire::propertySynthesizer(SpatieDataSynth::class);
    }
}
