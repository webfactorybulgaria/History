<?php

namespace TypiCMS\Modules\History\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Custom\Services\Cache\LaravelCache;
use TypiCMS\Modules\History\Custom\Models\History;
use TypiCMS\Modules\History\Custom\Repositories\CacheDecorator;
use TypiCMS\Modules\History\Custom\Repositories\EloquentHistory;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.history'
        );

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'history');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'history');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/history'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');
        $this->publishes([
            __DIR__.'/../resources/assets' => base_path('resources/assets'),
        ], 'assets');

        AliasLoader::getInstance()->alias(
            'History',
            'TypiCMS\Modules\History\Custom\Facades\Facade'
        );
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\History\Custom\Providers\RouteServiceProvider');

        $app->bind('TypiCMS\Modules\History\Custom\Repositories\HistoryInterface', function (Application $app) {
            $repository = new EloquentHistory(new History());
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], ['history'], 10);

            return new CacheDecorator($repository, $laravelCache);
        });
    }
}
