<?php

namespace Msucevan\Swapi;

use Illuminate\Support\ServiceProvider;
use Msucevan\Swapi\Console\Commands\CreateUniverse;

class SwapiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateUniverse::class,
            ]);
        }
    }
}
