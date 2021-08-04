<?php

namespace Armcanada\LaravelReferredField;

use Illuminate\Support\ServiceProvider;

class LaravelReferredFieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-referred-field');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-referred-field');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        //if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-referred-field.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-referred-field'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-referred-field'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-referred-field'),
            ], 'lang');*/

            // Publishing the migrations.
            if(!class_exists('CreateReferredFieldsTable')) {
                $this->publishes([
                    __DIR__.'/../database/migrations/create_referred_fields_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_referred_fields_table.php'),
                ], 'migrations');
            }

            // Registering package commands.
            // $this->commands([]);
      //  }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-referred-field');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-referred-field', function () {
            return new LaravelReferredField;
        });
    }
}
