<?php

namespace EmtiazZahid\LaravelComposer;

use Illuminate\Support\ServiceProvider;

class LaravelComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('LaravelComposerParser', function () {
            return new LaravelComposerParser();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (method_exists($this, 'package')) {
            $this->package('emtiazzahid/laravel-composer', 'laravel-composer', __DIR__ . '/../../');
        }

        if (method_exists($this, 'loadViewsFrom')) {
            $this->loadViewsFrom(__DIR__.'/../../views', 'laravel-composer');
        }

        if (method_exists($this, 'publishes')) {
            $this->publishes([
                __DIR__.'/../../views' => base_path('/resources/views/vendor/laravel-composer'),
            ], 'views');
        }

        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }
}
