<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Observers\SolicitudObserver;
use App\Models\Solicitude;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        //\Illuminate\Support\Facades\URL::forceScheme('https');
        Paginator::useBootstrap();
        //Solicitude::observe(SolicitudObserver::class);

    }
}
