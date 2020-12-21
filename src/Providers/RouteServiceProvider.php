<?php


namespace Kamansoft\Klorchid\Providers;


use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

    public function boot(){

        Route::pushMiddlewareToGroup('platform','kusertrue');
        parent::boot();
    }

    public function map(){

    }




}