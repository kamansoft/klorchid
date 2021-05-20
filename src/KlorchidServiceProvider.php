<?php

namespace Kamansoft\Klorchid;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Kamansoft\Klorchid\Console\Commands\BackupAction;
use Kamansoft\Klorchid\Console\Commands\KeditScreenCommand;
use Kamansoft\Klorchid\Console\Commands\KlorchidEloquentRepositoryCommand;
use Kamansoft\Klorchid\Console\Commands\KlorchidInstallCommand;
use Kamansoft\Klorchid\Console\Commands\KlorchidMultiModeScreenCommand;
use Kamansoft\Klorchid\Console\Commands\KlorchidMigrationCommand;
use Kamansoft\Klorchid\Console\Commands\KlorchidModelCommand;
use Kamansoft\Klorchid\Console\Commands\SystemUserAddCommand;
use Kamansoft\Klorchid\Database\Migrations\KlorchidMigrationCreator;
use Kamansoft\Klorchid\Http\Middleware\KlorchidKuserEnabled;
use Kamansoft\Klorchid\Http\Middleware\KlorchidLocalization;

use Kamansoft\Klorchid\Notificator\NotificaterInterface;
use Kamansoft\Klorchid\Notificator\Notificator;

use Kamansoft\Klorchid\Providers\KlorchidRouteServiceProvider;
use Kamansoft\Klorchid\Repositories\KlorchidEloquentRepository;
use Kamansoft\Klorchid\Repositories\Contracts\KlorchidRepositoryInterface;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\Providers\FoundationServiceProvider as OrchidFoundationServiceProvider;

class KlorchidServiceProvider extends ServiceProvider
{

    static public $blaming_fields_migration_filename = "2020_11_03_155648_add_klorchid_blaming_fields_to_users_table";
    /**
     * The available command shortname.
     *
     * @var array
     */
    public $commands = [
        SystemUserAddCommand::class,
        BackupAction::class,
        KeditScreenCommand::class,
        KlorchidMigrationCommand::class,
        KlorchidModelCommand::class,
        KlorchidInstallCommand::class,
        KlorchidEloquentRepositoryCommand::class,
        KlorchidMultiModeScreenCommand::class,

    ];
    protected $dashboard;

    public function boot(Dashboard $dashboard)
    {


        $this->dashboard = $dashboard;
        $this
            ->registerKlorchidUserModel()
            ->registerConfig()
            ->registerKlorchid()
            //->registerProviders()
            ->registerTranslations()
            ->registerMigrations()
            ->registerSeeders()
            //->registerMiddlewaresAlias()
            //->reisterMiddlewareGroups()
            ->registerRoutes()
            ->registerViews();

        $this->registerPermissions($dashboard);


    }

    /**
     * Register views & Publish views.
     *
     * @return $this
     */
    public function registerViews(): self
    {
        ///$path = Dashboard::path('resources/views');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'klorchid');

        $this->publishes([
            __DIR__ . '/../resources/views/errors' => resource_path('views/errors'),
        ], 'klorchid-error-views');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/klorchid'),
        ], 'klorchid-views');

        return $this;
    }

    protected function registerRoutes(): self
    {

        //a$this->loadRoutesFrom(__DIR__ . '/routes/klorchid.php','platform');
        $this->publishes([
            __DIR__ . '/../routes/platform.php' => base_path('routes/platform.php'),
            __DIR__ . '/../routes/klorchid.php' => base_path('routes/klorchid.php'),
        ], 'klorchid-platform-routes');

        $this->loadRoutesFrom(__DIR__ . '/../routes/klorchid_locale.php', 'klorchid');
        return $this;
    }

    protected function registerMigrations(): self
    {

        if ($this->app->runningInConsole()) {
            // Export the migration

            $this->publishes([
                //__DIR__ . '/../database/migrations/2020_11_03_155647_add_system_user_to_users_table.php' => database_path('migrations/2020_11_03_155647_add_system_user_to_users_table.php'),
                __DIR__ . '/../database/migrations/' . Self::$blaming_fields_migration_filename . '.php' => database_path('migrations/' . Self::$blaming_fields_migration_filename . '.php'),
                __DIR__ . '/../database/migrations/2020_11_12_143432_add_kmodel_fields_to_users_table.php' => database_path('migrations/2020_11_12_143432_add_kmodel_fields_to_users_table.php'),
                __DIR__ . '/../database/migrations/2020_12_01_175607_add_klorchid_avatar_column_to_users_table.php' => database_path('migrations/2020_12_01_175607_add_klorchid_avatar_column_to_users_table.php'),

                //__DIR__ . '/../database/migrations/2020_09_02_120819_create_app_settings_table.php' => database_path('migrations/2020_09_02_120819_create_app_settings_table.php'),
                __DIR__ . '/../database/migrations/2021_05_18_112932_create_countries_table.php' => database_path('migrations/2021_05_18_112932_create_countries_table.php'),
                __DIR__ .'/../database/migrations/2021_05_18_112933_create_regions_table.php'=>database_path('migrations/2021_05_18_112933_create_regions_table.php'),
                __DIR__ . '/../database/migrations/2021_05_18_161302_create_states_table.php' => database_path('migrations/2021_05_18_161302_create_states_table.php'),
                __DIR__ . '/../database/migrations/2021_05_18_190635_create_cities_table.php' => database_path('migrations/2021_05_18_190635_create_cities_table.php'),

            ], 'klorchid-migrations');


        }

        //$this->loadMigrationsFrom(__DIR__ .'../database/migrations');
        return $this;
    }


    protected function registerSeeders(): self
    {


        if ($this->app->runningInConsole()) {
            // Export the migration

            $this->publishes([
                __DIR__ . '/../database/seeders/CountrySeeder.php' => database_path('seeders/CountrySeeder.php'),

            ], 'klorchid-seeders');


        }

        return $this;
    }

    /**
     * Register translations.
     *
     * @return $this
     */
    public function registerTranslations(): self
    {
        //dd(__DIR__ . '/../resources/lang/');
        //$this->loadJsonTranslationsFrom(__DIR__ . '/../resources/lang/');

        $klorchid_lang_path = __DIR__ . '/../resources/lang';
        $this->publishes(
            [$klorchid_lang_path => resource_path('lang')],
            'klorchid-lang'
        );

        return $this;
    }

    protected function registerKlorchid()
    {

        $this->publishes([
            //__DIR__ . '/../resources/stubs/app/Klorchid' => app_path('Klorchid'),
            __DIR__ . '/../resources/stubs/app/Permissions' => app_path('Permissions'),
            // __DIR__ . '/../resources/stubs/app/Providers' => app_path('Providers'),
            //__DIR__ . '/../resources/stubs/app/Repositories' => app_path('Repositories'),
        ], 'klorchid-commons');

        return $this;
    }

    /**
     * Register migrate.
     *
     * @return $this
     */
    protected function registerConfig(): self
    {

        $this->publishes([
            __DIR__ . '/../config/klorchid_config.php' => config_path('klorchid.php'),
        ], 'klorchid-config');

        return $this;
    }

    public function registerKlorchidUserModel()
    {
        Dashboard::useModel(\Orchid\Platform\Models\User::class, \Kamansoft\Klorchid\Models\KlorchidUser::class);
        return $this;
    }

    protected function registerPermissions(Dashboard $dashboard): self
    {
        //todo: we must cache this to avoid loops
        if (file_exists(app_path('Permissions'))) {
            collect(File::files(app_path('Permissions')))
                ->map(function ($file) {
                    return require_once $file->getPathname();
                })
                ->collapse()
                ->map(function ($values, $group_name) use ($dashboard) {
                    foreach ($values as $perm_key => $name) {
                        $dashboard->registerPermissions(
                            ItemPermission::group($group_name)
                                ->addPermission(
                                    $perm_key,
                                    $name
                                )
                        );
                    }
                });


        } else {
            Log::alert("There is NOT Permission Folder to scan for permissions");
        }
        return $this;

    }


    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/klorchid_package_config.php', 'klorchid'
        );
        $this
            ->registerProviders()
            ->registerRepository()
            ->registerMiddlewaresAlias()
            ->reisterMiddlewareGroups()
            ->registerKmigrationCreator()
            ->registerKmigrationCommandSingleton()
            ->registerNotificater()
            ->registerNotificator()
            ->registerCommands();

    }

    protected function registerCommands(): self
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }

        return $this;
    }

    protected function registerNotificater(): self
    {
        $this->app->bind(NotificaterInterface::class, Notificator::class);


        return $this;
    }

    protected function registerNotificator(): self
    {
        $this->app->singleton(Notificator::class, static function () {
            return new Notificator();
        });
        return $this;
    }

    public function registerKmigrationCommandSingleton()
    {
        $this->app->singleton(KlorchidMigrationCommand::class, function ($app) {
            $creator = $app[KlorchidMigrationCreator::class];
            $composer = $app['composer'];

            return new KlorchidMigrationCommand($creator, $composer);
        });
        return $this;
    }

    public function registerKmigrationCreator()
    {

        $this->app->singleton(KlorchidMigrationCreator::class, function ($app) {
            return new KlorchidMigrationCreator($app['files'], __DIR__ . '/../resources/stubs');
        });
        return $this;
    }

    public function reisterMiddlewareGroups()
    {

        Route::middlewareGroup('klorchid-middlewares', [
            'kusertrue',
            'klorchidlocalization', //KlorchidKuserEnabled::class,

        ]);

        return $this;
    }

    /**
     * Register all middleware alias for<s routes
     * @return $this
     */
    public function registerMiddlewaresAlias()
    {
        $router = $this->app->make(Router::class);
        //$router->aliasMiddleware('klorchidlocalization', KlorchidLocalization::class);
        //$router->aliasMiddleware('kusertrue', KlorchidKuserEnabled::class);

        foreach ($this->getAliasedMidlewares() as $alias => $middleware) {
            $router->aliasMiddleware($alias, $middleware);
        }

        return $this;
    }

    /**
     * returns the middleware to be registered with its aliases
     * @return array|string[]
     */
    public function getAliasedMidlewares(): array
    {
        return [
            'klorchidlocalization' => KlorchidLocalization::class,
            'kusertrue' => KlorchidKuserEnabled::class,
        ];
    }

    protected function registerRepository(): self
    {

        //$this->app->bind(KlorchidRepositoryInterface::class, KlorchidEloquentRepository::class);

        return $this;
    }

    /**
     * Register provider.
     *
     * @return $this
     */
    public function registerProviders(): self
    {

        foreach ($this->provides() as $provide) {

            $this->app->register($provide);
        }

        return $this;
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {

        return [
            OrchidFoundationServiceProvider::class,
            KlorchidRouteServiceProvider::class,

        ];
    }

    /**
     * Register migrate.
     *
     * @return $this
     */
    protected function registerDatabase(): self
    {
        $this->publishes([
            Dashboard::path('database/migrations') => database_path('migrations'),
        ], 'klorchid-migrations');

        return $this;
    }

    /**
     * Register assets.
     *
     * @return $this
     */
    protected function registerAssets(): self
    {
        $this->publishes([
            Dashboard::path('resources/js') => resource_path('js/orchid'),
            Dashboard::path('resources/sass') => resource_path('sass/orchid'),
        ], 'orchid-assets');

        return $this;
    }
}
