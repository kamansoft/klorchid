<?php


namespace Kamansoft\Klorchid\Providers;


use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;



use Laravel\Jetstream\Features;
use Illuminate\Routing\Router;


class KlorchidRouteServiceProvider extends RouteServiceProvider
{

    public function boot()
    {

        Route::pushMiddlewareToGroup('platform', 'kusertrue');
        parent::boot();
    }
     
}
