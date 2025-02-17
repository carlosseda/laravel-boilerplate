<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
      #Admin

      view()->composer([
        'components.admin-form-generator'],
        'App\Http\ViewComposers\Admin\Language'
      );

      view()->composer([
        'components.admin-form-generator'],
        'App\Http\ViewComposers\Admin\Town',
      );
      
    }
}
