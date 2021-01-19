<?php


namespace Kamansoft\Klorchid\Providers;


use Illuminate\Contracts\Http\Kernel;


use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

use Orchid\Platform\Dashboard;
use Laravel\Jetstream\Features;
use Illuminate\Routing\Router;


class KlorchidRouteServiceProvider extends RouteServiceProvider
{

    public function boot()
    {
        Route::pushMiddlewareToGroup('platform', 'kusertrue');

        //todo: check an rewrite this with Route::pushMiddlewareToGroup
        //Route::pushMiddlewareToGroup('web', 'klorchidlocalization'); // is not working
        $kernel = $this->app->make(Kernel::class);
        $kernel->appendMiddlewareToGroup("web", 'klorchidlocalization');
        //dd(config('platform.domain'));
        parent::boot();

    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        /*
         * Public
         */

        /*Route::domain((string)config('platform.domain'))
            ->prefix(Dashboard::prefix('/'))
            ->as('platform.')
            ->middleware(config('platform.middleware.public'))
            ->group(Dashboard::path('routes/public.php'));

        */

        /*
         * Application
         */
        
        if (file_exists(base_path('routes/klorchid.php'))) {
            Route::domain((string)config('platform.domain'))
                ->prefix(Dashboard::prefix('/'))
                ->middleware(config('platform.middleware.private'))
                ->group(base_path('routes/klorchid.php'));
        }
        
    }
}
