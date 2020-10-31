<?php

namespace Kamansoft\Klorchid\Console\Commands;

use Illuminate\Console\Command;
use Orchid\Platform\Commands\ScreenCommand;
use Orchid\Platform\Dashboard;
use Illuminate\Support\Str;

class KeditScreenCommand extends ScreenCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kaman:editscreen {name?} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new edit screen';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'KeditScreen';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return app_path('Kaman/resources/stubs/keditscreen.stub');
    }

        /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        $app_name = Str::upper((config('app.name')));
    
        //DIRECTORY_SEPARATOR.$app_name.DIRECTORY_SEPARATOR.
        return $rootNamespace.'\\'.$app_name.'\Screens';
    }



}
