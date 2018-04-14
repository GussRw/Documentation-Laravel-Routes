<?php

namespace GussRw\LaravelRoutes;

use Illuminate\Support\ServiceProvider;

class LaravelRoutesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['routes'] = $this->app->share(function($app) {
            return new Routes;
        });
    }
}
