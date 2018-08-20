<?php

namespace App\Providers;

use App\Services\Api\SysApiServices;
use Illuminate\Support\ServiceProvider;

class SysApiServiceProvider extends ServiceProvider
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
        $this->app->singleton('sysApi', function($app){
            return new SysApiServices();
        });
    }
}
