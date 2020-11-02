<?php

namespace Kamansoft\Klorchid;

use Illuminate\Support\ServiceProvider;
use Kamansoft\Klorchid\Console\Commands\BackupAction;
use Kamansoft\Klorchid\Console\Commands\KeditScreenCommand;
use Kamansoft\Klorchid\Console\Commands\KmigrationCommand;
use Kamansoft\Klorchid\Console\Commands\KmodelCommand;
use Kamansoft\Klorchid\Console\Commands\KlorchidInstallCommand;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;


class KlorchidServiceProvider extends ServiceProvider
{
    /**
     * The available command shortname.
     *
     * @var array
     */
    public $commands = [
        BackupAction::class,
        KeditScreenCommand::class,
        KmigrationCommand::class,
        KmodelCommand::class,
        KlorchidInstallCommand::class
    ];


    public function boot(Dashboard $dashboard)
    {

        $this->registerConfig()
            ->registerRoutes();
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }

        $dashboard->registerPermissions(
            ItemPermission::group('Systems Users')
                ->addPermission('systems.users.list','List')
                ->addPermission('systems.users.create', 'Create')
                ->addPermission('systems.users.edit', 'Edit')
                ->addPermission('systems.users.invalidate', 'Invalidate')
                ->addPermission('systems.users.statuschange', 'Status Change')
        );
        $dashboard->registerPermissions(
            ItemPermission::group('Systems Roles')
                ->addPermission('systems.roles.list','List')
                ->addPermission('systems.roles.create', 'Create')
                ->addPermission('systems.roles.edit', 'Edit')
                ->addPermission('systems.roles.invalidate', 'Invalidate')
                ->addPermission('systems.roles.statuschange', 'Status Change')
        );

    }


    protected function registerRoutes(): self
    {


        $this->loadRoutesFrom(__DIR__ . '/routes/klorchid.php');


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
}
