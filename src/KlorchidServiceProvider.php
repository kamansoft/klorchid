<?php

namespace Kamansoft\Klorchid;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Kamansoft\Klorchid\Console\Commands\BackupAction;
use Kamansoft\Klorchid\Console\Commands\KeditScreenCommand;
use Kamansoft\Klorchid\Console\Commands\KlorchidInstallCommand;
use Kamansoft\Klorchid\Console\Commands\KmodelCommand;
use Kamansoft\Klorchid\Console\Commands\SystemUserAddCommand;
use Kamansoft\Klorchid\Http\Middleware\KlorchidKuserEnabled;
use Kamansoft\Klorchid\Http\Middleware\KlorchidLocalization;
use Kamansoft\Klorchid\Models\Kuser;
use Kamansoft\Klorchid\Providers\KlorchidPlatformProvider;
use Kamansoft\Klorchid\Providers\RouteServiceProvider;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\Providers\FoundationServiceProvider;
use Orchid\Support\Facades\Dashboard as DashboardFacade;
use Laravel\Jetstream\Features;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

use Orchid\Platform\Http\Middleware\Access;
use Orchid\Platform\Http\Middleware\TurbolinksLocation;


use Kamansoft\Klorchid\Providers\RouteServiceProvider as KlorchidRouteServiceProvider;


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
        //KmigrationCommand::class,
        KmodelCommand::class,
        KlorchidInstallCommand::class,
    ];

    public function boot(Dashboard $dashboard)
    {

        \Debugbar::info('Stating KlorchidService Provider boot Method');

        if (config('auth.providers.users.model') !== Kuser::class) {
            throw new \Exception('Klorchid package needs the user model auth provider setted as as ' . Kuser::class . ' type, instead ' . config('auth.providers.users.model') . ' found');
        }

        Dashboard::useModel(\Orchid\Platform\Models\User::class, Kamansotf\Klorchid\Models\Kuser::class);
        $this->registerConfig()
            //->registerProviders()
            ->registerTranslations()
            ->registerMigrations()
            //->registerMiddlewaresAlias()
            // ->reisterMidlewareGroups()
            ->addMiddlewaresToGroups()
            ->registerRoutes()
            ->registerViews();


        $dashboard->registerPermissions(
            ItemPermission::group('Systems Users')
                ->addPermission('platform.systems.users.list', __('List'))
                ->addPermission('platform.systems.users.view', 'View')
                ->addPermission('platform.systems.users.delete', 'Delete')
                ->addPermission('platform.systems.users.create', __('Create'))
                ->addPermission('platform.systems.users.edit', 'Edit')
                ->addPermission('platform.systems.users.invalidate', 'Invalidate')
                ->addPermission('platform.systems.users.permissions.edit', 'Edit Permissions')
                ->addPermission('platform.systems.users.statuschange', 'Status Change')
        );
        $dashboard->registerPermissions(
            ItemPermission::group('Systems Roles')
                ->addPermission('platform.systems.roles.list', 'List')
                ->addPermission('platform.systems.roles.view', 'View')
                ->addPermission('platform.systems.roles.delete', 'Delete')
                ->addPermission('platform.systems.roles.create', __('Create'))
                ->addPermission('platform.systems.roles.edit', 'Edit')
                ->addPermission('platform.systems.roles.invalidat', 'Invalidate')
                ->addPermission('platform.systems.roles.statuschange', 'Status Change')
        );

        \Debugbar::info('/End KlorchidService Provider boot Method');


    }

    protected function registerCommands(): self
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }


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
            ], 'klorchid-migrations');

            /*if (!class_exists('Kuser')) {
                                $this->publishes([
                                    __DIR__ . '/../database/migrations/add_klorchid_blaming_fields_to_users_table.php.stub .stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_posts_table.php'),
                                    // you can add any number of migrations here
                                ], 'migrations');
            */
        }

        //$this->loadMigrationsFrom(__DIR__ .'../database/migrations');
        return $this;
    }

    protected function registerRoutes(): self
    {

        //a$this->loadRoutesFrom(__DIR__ . '/routes/klorchid.php','platform');
        $this->publishes([
            __DIR__ . '/../routes/platform.php' => base_path('routes/platform.php'),
            //__DIR__ . '/../routes/klorchid.php' => base_path('routes/klorchid.php'),
        ], 'klorchid-platform-routes');

        $this->loadRoutesFrom(__DIR__ . '/../routes/klorchid.php', 'klorchid');
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
     * Register translations.
     *
     * @return $this
     */
    public function registerTranslations(): self
    {

        //$this->loadJsonTranslationsFrom(__DIR__ . '/../resources/lang/');

        $klorchid_lang_path = __DIR__ . '/../resources/lang';
        $this->publishes(
            [$klorchid_lang_path => resource_path('lang')]
            , 'klorchid-lang');

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
            __DIR__ . '/../resources/views' => resource_path('views/vendor/klorchid'),
        ], 'views');

        return $this;
    }


    /**
     * add  klorchid middleware to existing groups
     * @return $this
     */
    public function addMiddlewaresToGroups()
    {

        $kernel = $this->app->make(Kernel::class);
        $kernel->appendMiddlewareToGroup('web', KlorchidLocalization::class);
        //die('a');
        //$kernel->appendMiddlewareToGroup('private', KlorchidKuserEnabled::class);
        $groups = $kernel->getMiddlewareGroups();

        return $this;
    }

    /**
     * Register all middleware alias to route
     * @return $this
     */
    public function registerMiddlewaresAlias()
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('klorchidlocalization', KlorchidLocalization::class);
        $router->aliasMiddleware('kusertrue', KlorchidKuserEnabled::class);
        return $this;

    }

    public function reisterMidlewareGroups()
    {

        Route::middlewareGroup('klorchid', [
            KlorchidKuserEnabled::class,

        ]);
        \Debugbar::info('klorchid Middleware gorup registered');
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
            FoundationServiceProvider::class,
            RouteServiceProvider::class,
        ];
    }


    public function register()
    {

        /*$this->mergeConfigFrom(
            __DIR__ . '/../config/klorchid_config.php', 'klorchid'
        );*/


        //$this->mergeConfigFrom(__DIR__ . '/../config/klorchid_jetstream_config.php', 'jetstream');
        //$this->addMiddlewaresToGroups();
        $this
            ->registerMiddlewaresAlias()
            ->reisterMidlewareGroups()
            ->registerProviders()
            ->registerCommands();


    }


}
