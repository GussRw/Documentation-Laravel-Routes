<?php

namespace GussRw\LaravelRoutes;

use Illuminate\Support\ServiceProvider;

class LaravelRoutesServiceProvider extends ServiceProvider
{
    protected $commands = [
        Commands\GenerateDocs::class
    ];
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__. '/Views/', 'laravel-routes');
        $this->loadTranslationsFrom(__DIR__.'/Lang/','laravel-routes');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }
}
