<?php

namespace Kamansoft\Klorchid;

use Illuminate\Support\ServiceProvider;


class KlorchidServiceProvider extends ServiceProvider
{
  public function register()
  {
    $this->commands([
      "Kamansoft\Klorchid\Console\Commands\BackupAction",
      "Kamansoft\Klorchid\Console\Commands\KeditScreenCommand",
      "Kamansoft\Klorchid\Console\Commands\KmigrationCommand",
      "Kamansoft\Klorchid\Console\Commands\KmodelCommand"
    ]);
  }

  public function boot()
  {
    if ($this->app->runningInConsole()) {
    }
  }
}
