<?php

namespace Kamansoft\Klorchid\Providers;

use Illuminate\Support\ServiceProvider;
use Kamansoft\Klorchid\Models\Kuser;
use Orchid\Support\Facades\Dashboard;


class KlorchidPlatformProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Dashboard::useModel(\Orchid\Platform\Models\User::class, Kuser::class);
    }
}
