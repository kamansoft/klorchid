<?php

declare (strict_types=1);

use App\Klorchid\Screens\User\KuserEditScreen;
use App\Klorchid\Screens\User\KuserListScreen;
use App\Klorchid\Screens\User\KuserProfileEditScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Klorchid Routes
|----------------------------------------0----------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the KlorchidRouteServiceProvider within a group which
| contains the need "dashboard" middleware group. also some of these routes
| WILL OVERRIDE platfor.php routes
|
 */


/*
|--------------------------------------------------------------------------
| platform.php routes overide
|----------------------------------------0----------------------------------
 */

// Main
Route::screen('/main', App\Klorchid\Screens\KlorchidMainScreen::class)
    ->name('platform.main');

Route::screen('profile', KuserProfileEditScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });

// Platform > System > Users
Route::screen('users/create', KuserEditScreen::class)
    ->name('platform.systems.users.add')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Add'), route('platform.systems.users.add'));
    });

Route::screen('users/{users}/edit', KuserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Edit'), route('platform.systems.users.edit', $user));
    });

// Platform > System > Users > User
Route::screen('users', KuserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.index')
            ->push(__('Users'), route('platform.systems.users'));
    });

/*
|--------------------------------------------------------------------------
| /platform.php routes overide
|----------------------------------------0----------------------------------
 */