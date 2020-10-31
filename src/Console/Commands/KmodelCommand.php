<?php

namespace Kamansoft\Klorchid\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class KmodelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kaman:model {name} {--keditscreen} {--migration}';

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
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->option('keditscreen')) {
            $this->createKeditScreen();
        }
        if ($this->option('migration')) {
            $this->createKmigration();
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


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return app_path('Kaman/resources/stubs/kmodel.stub');
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
        $app_name = ucfirst(config('app.name'));
        //DIRECTORY_SEPARATOR.$app_name.DIRECTORY_SEPARATOR.
        return $rootNamespace.'\\'.$app_name.'\Screens';
    }



}
