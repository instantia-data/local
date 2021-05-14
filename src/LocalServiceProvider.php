<?php

namespace Local;

use Illuminate\Support\ServiceProvider;

class LocalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/local.php', 'local');
        $this->mergeConfigFrom(__DIR__.'/../config/vendor.php', 'vendor-local');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {


        /**
         * Migrations
         */
        $this->loadMigrationsFrom(__DIR__.'/../database');
        /**
         * Views
         */
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'local');
        /**
         * Translations
         */
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'local');
        \Local\Translations\Services\TranslationsService::$library['local'] = __DIR__;
        
        /**
         * Publish
         */
        //$this->publishes([__DIR__.'/../resources/views' => resource_path('views')], 'id-local-views');
        $this->publishes([__DIR__.'/../resources/lang' => resource_path('lang')], 'id-local-lang');
        //$this->publishes([__DIR__.'/../assets/publish/controllers' => app_path('Http/Controllers/Local')], 'id-local-controller');
        $this->publishes([__DIR__.'/../routes/routes.php' => base_path('routes/local.php')], 'id-local-route');
        $this->publishes([__DIR__.'/../config/local.php' => config_path('local.php')], 'id-local-config');
        //Assets
        $this->publishes([__DIR__.'/../assets/css' => public_path('css/instantia/local')], 'id-local-css');
        $this->publishes([__DIR__.'/../assets/js' => public_path('js/instantia/local')], 'id-local-js');
    }
}
