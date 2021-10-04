<?php

namespace klorchid\src\Console\Commands;

use Illuminate\Database\Console\Seeds\SeederMakeCommand;

class CsvSeederCommand extends SeederMakeCommand
{

     /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:csv-seeder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new seeder class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'CsvSeeder';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        parent::handle();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $stub_path = __DIR__ . '/../../../resources/stubs/';
        //$file=""

        return $this->resolveStubPath('/stubs/seeder.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return is_file($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        if (is_dir($this->laravel->databasePath().'/seeds')) {
            return $this->laravel->databasePath().'/seeds/'.$name.'.php';
        } else {
            return $this->laravel->databasePath().'/seeders/'.$name.'.php';
        }
    }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function qualifyClass($name)
    {
        return $name;
    }

}