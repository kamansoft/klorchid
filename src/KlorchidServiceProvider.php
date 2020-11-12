<?php

namespace Kamansoft\Klorchid;

use Illuminate\Support\ServiceProvider;
use Kamansoft\Klorchid\Console\Commands\BackupAction;
use Kamansoft\Klorchid\Console\Commands\KeditScreenCommand;
use Kamansoft\Klorchid\Console\Commands\KmigrationCommand;
use Kamansoft\Klorchid\Console\Commands\KmodelCommand;
use Kamansoft\Klorchid\Console\Commands\KlorchidInstallCommand;
use Kamansoft\Klorchid\Console\Commands\SystemUserAddCommand;
use Kamansoft\Klorchid\Providers\KlorchidPlatformProvider;
use Kamansoft\Klorchid\Providers\PlatformProvider;
use Orchid\Platform\Commands\AdminCommand;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;


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
        KlorchidInstallCommand::class
    ];


    public function boot(Dashboard $dashboard)
    {

        $this->registerConfig()
            ->registerCommands()
            ->registerMigrations()
            ->registerRoutes()
            ->registerProviders();


        $dashboard->registerPermissions(
            ItemPermission::group('Systems Users')
                ->addPermission('systems.users.list', 'List')
                ->addPermission('systems.users.add', __('Add'))
                ->addPermission('systems.users.edit', 'Edit')
                ->addPermission('systems.users.invalidate', 'Invalidate')
                ->addPermission('systems.users.statuschange', 'Status Change')
        );
        $dashboard->registerPermissions(
            ItemPermission::group('Systems Roles')
                ->addPermission('systems.roles.list', 'List')
                ->addPermission('systems.roles.add', __('Add'))
                ->addPermission('systems.roles.edit', 'Edit')
                ->addPermission('systems.roles.invalidate', 'Invalidate')
                ->addPermission('systems.roles.statuschange', 'Status Change')
        );

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
                    __DIR__ . '/../database/migrations/'.Self::$blaming_fields_migration_filename.'.php' => database_path('migrations/'.Self::$blaming_fields_migration_filename.'.php')
            ], 'kmigrations');

            /*if (!class_exists('Kuser')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/add_klorchid_blaming_fields_to_users_table.php.stub .stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_posts_table.php'),
                    // you can add any number of migrations here
                ], 'migrations');
            }*/
        }

        //$this->loadMigrationsFrom(__DIR__ .'../database/migrations');
        return $this;
    }


    protected function registerRoutes(): self
    {


        //a$this->loadRoutesFrom(__DIR__ . '/routes/klorchid.php','platform');
        $this->publishes([__DIR__ . '/resources/stubs/platform.stub.php' => base_path('routes/platform.php')],'kroutes');

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
            __DIR__ . '/klorchid_config.php' => config_path('klorchid.php'),
        ], 'config');

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
        ], 'migrations');

        return $this;
    }

    /**
     * Register translations.
     *
     * @return $this
     */
    public function registerTranslations(): self
    {
        $this->loadJsonTranslationsFrom(Dashboard::path('resources/lang/'));

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
        $path = Dashboard::path('resources/views');

        $this->loadViewsFrom($path, 'platform');

        $this->publishes([
            $path => resource_path('views/vendor/platform'),
        ], 'views');

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


    public function register()
    {

        $this->mergeConfigFrom(
            __DIR__ . '/klorchid_config.php', 'klorchid'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            KlorchidPlatformProvider::class
        ];
    }
}
