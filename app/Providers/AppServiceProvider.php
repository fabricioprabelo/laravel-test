<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useTailwind();
        View::share('locale', str_replace('_', '-', app()->getLocale()));
        View::share('localeFallback', str_replace('_', '-', config('app.fallback_locale')));
    }
}
