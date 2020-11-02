<?php


use Kamansoft\Klorchid\Screens\User\KuserEditScreen;
use Tabuna\Breadcrumbs\Trail;

use App\Orchid\Screens\TestScreen;

/*
// Platform > System > Users
Route::screen('test', TestScreen::class)
    ->name('platform.test');*/


Route::screen('test', \App\Orchid\Screens\TestScreen::class,'platform.screens.test');