<?php

namespace Kamansoft\Klorchid\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;


class KlorchidModelCommand extends GeneratorCommand
{

    private $status_types = [
        'boolean-binary',
        'integer-multistate',
        'char-multistate'

    ];
    private $status_type = 'boolean-binary';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'klorchid:model 
        {name? : The name of the Model Class} 
        {--status-type= : Specify The type of model based on status: [ boolean-binary (default), integer-multistate, char-multistate ]  }
        {--m|migration : Create a migration file using the name of the model} 
        {--M|multimodescreen : Create a KlorchidMultimodeScreen class file using model class name} 
        {--c|crudscreen : Create a KlorchidCrudScreenBK class file using model class name} 
        {--l|listscreen : Create KlorchidListScreen class file using model class name} 
        {--a|useAppNamePath : Create files inside a folder with the name as laravel app_name config value}
        {--pivot}';

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
        $stub_path = __DIR__ . '/../../../resources/stubs/';

        $binary = 'klorchid.binarystatus.model.stub';


        switch ($this->status_type){
            case 'binary':
                $stub_path .=$binary;
                break;
            default:
                $stub_path.=$binary;
        }

        return $stub_path;
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
        $path_to_return = $rootNamespace;

        if ($this->option('useAppNamePath')) {
            $app_name = Str::studly((config('app.name')));
            $app_name_screens_path = '\\' . $app_name . '\Models';
            $path_to_return = $path_to_return . '\\' . $app_name_screens_path;
        } else {
            $path_to_return = $path_to_return . '\Models';
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

        if ($this->option('multimodescreen')) {
            $this->line('a klorchid multimode screen  will be created');
            // $this->createKeditScreen();
        }
        if ($this->option('migration')) {
            $this->line('a migration file will be created');
            $this->createKlorchidMigration();
        }

        if ($this->option('useAppNamePath')) {
            echo "use appname config var ";
            $this->line('app_name config var value will be used as path');
        }

        $this->setStatusType();
        $this->line('a ' . $this->status_type . ' model will be created...');

        parent::handle();
        //if ($this->option('status'))
        return 0;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    protected function setStatusType()
    {
        $status_type = $this->input->getOption('status-type');
        if (is_null($status_type)) {

        } else {
            if (in_array($status_type, $this->status_types)) {
                $this->status_type = $status_type;
            } else {
                $available_status = implode(', ', $this->status_types);
                throw new \Exception($status_type . ' is not a valid model status type for creation.  Available status types are: ' . $available_status);
            }
        }
        return $this;
    }

    protected function createKlorchidEditScreen()
    {
        $screen_folder_name = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());


        $this->call('kaman:editscreen', array_filter([
            'name' => "{$screen_folder_name}EditScreen",
            //'--model' => $this->option('resource') || $this->option('api') ? $modelName : null,
            //'--api' => $this->option('api'),
        ]));
    }

    /**
     * Create a migration file for the model.
     *
     * @return void
     */
    protected function createKlorchidMigration()
    {
        $table = Str::snake(Str::pluralStudly(class_basename($this->argument('name'))));

        if ($this->option('pivot')) {
            $table = Str::singular($table);
        }

        $this->call('klorchid:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
            '--uuid'
        ]);
    }


    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)
            ->replaceTable($stub, $name)
            ->replaceClass($stub, $name);
    }


    protected function replaceTable(&$stub, $name)
    {

        $table = Str::snake(Str::pluralStudly(class_basename($this->argument('name'))));

        if ($this->option('pivot')) {
            $table = Str::singular($table);
        }


        $stub = str_replace(['{{ table }}', '{{table}}'], [$table, $table], $stub);

        return $this;

    }


}
