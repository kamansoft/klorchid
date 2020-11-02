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
    protected $signature = 'klorchid:editscreen 
        {name? : The name of the screen class } 
        {--a|useAppNamePath : Create files inside a folder with the name as laravel app_name config value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new klorchid edit screen';

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
        //return app_path('Kaman/resources/stubs/keditscreen.stub');
        return __DIR__ .'/../../resources/stubs/keditscreen.stub';
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

        $app_name_path = '';
        $path_to_return  = $rootNamespace;

        if ($this->option('useAppNamePath')) {
            $app_name = Str::studly((config('app.name')));
            $app_name_screens_path = '\\'.$app_name.'\Screens';
            $path_to_return = $path_to_return.'\\'.$app_name_screens_path;
        }else{
            $path_to_return = $path_to_return.'\Screens';
        }

        return $path_to_return;

    }



}
