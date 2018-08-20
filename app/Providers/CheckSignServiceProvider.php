<?php

namespace App\Providers;

use App\Services\CheckSignServices;
use Illuminate\Support\ServiceProvider;

class CheckSignServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('checkSign', function($app){
            return new CheckSignServices();
        });
    }
}
