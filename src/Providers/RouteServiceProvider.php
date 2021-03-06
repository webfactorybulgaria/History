<?php

namespace TypiCMS\Modules\History\Providers;

use Illuminate\Routing\Router;
use TypiCMS\Modules\Core\Shells\Providers\BaseRouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\History\Shells\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function (Router $router) {
            /*
             * API routes
             */
            $router->get('api/history', 'ApiController@index')->name('api::index-history');
            $router->delete('api/history', 'ApiController@destroy')->name('api::destroy-history');
        });
    }
}
