<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\LocaleService\LocaleService;
use App\Models\Locale;

class LocaleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
      $this->app->singleton(LocaleService::class, function ($app) {
        return new LocaleService(new Locale());
      });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
