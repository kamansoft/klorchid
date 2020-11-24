<?php

namespace Kamansoft\Klorchid\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;


class KmodelCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'klorchid:model 
        {name? : The name of the Model Class} 
        {--m|migration : Create a migration file using the name of the model} 
        {--e|editscreen : Create a EditScreen class file using model class name} 
        {--l|listscreen : Create ListScreen class file using model class name} 
        {--a|useAppNamePath : Create files inside a folder with the name as laravel app_name config value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new Kaman Model';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $type = 'Model';


        /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . '/../../resources/stubs/kmodel.stub';
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
            $app_name_screens_path = '\\'.$app_name.'\Models';
            $path_to_return = $path_to_return.'\\'.$app_name_screens_path;
        }else{
            $path_to_return = $path_to_return.'\Models';
        }

        return $path_to_return;

    }




    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //parent::handle();
        if ($this->option('editscreen')) {
            echo "kedit screen runned";
            // $this->createKeditScreen();
        }
        if ($this->option('migration')) {
            echo "migration runned";
            //$this->createKmigration();
        }

        if ($this->option('useAppNamePath')){
            echo "use appname config var ";
        }
        return 0;
    }

    protected  function createKeditScreen(){
        $screen_folder_name = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());


        $this->call('kaman:editscreen', array_filter([
            'name'  => "{$screen_folder_name}EditScreen",
            //'--model' => $this->option('resource') || $this->option('api') ? $modelName : null,
            //'--api' => $this->option('api'),
        ]));
    }

        /**
     * Create a migration file for the model.
     *
     * @return void
     */
    protected function createKmigration()
    {
        $table = Str::snake(Str::pluralStudly(class_basename($this->argument('name'))));



        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }





}
