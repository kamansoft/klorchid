<?php

namespace Kamansoft\Klorchid\Console\Commands;

class KlorchidListLayoutCommand extends \Illuminate\Console\GeneratorCommand
{
        /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'klorchid:make:layout:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new List Layout';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'KlorchidListLayout';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        //return app_path('Kaman/resources/stubs/keditscreen.stub');
        return __DIR__ . '/../../../resources/stubs/klorchid.multimode.screen.stub';
    }



    protected function getClassNamespaceFromPath($path){
        return str_replace('/','\\',$path);
    }

    protected function getModelClassName(){
        $model_name = $this->argument('repository');
        $exploded = explode('/',$model_name);
        return end($exploded);
    }
}