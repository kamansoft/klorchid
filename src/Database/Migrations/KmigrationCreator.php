<?php


namespace Kamansoft\Klorchid\Database\Migrations;


use Illuminate\Database\Migrations\MigrationCreator;

class KmigrationCreator extends MigrationCreator
{
    /**
     * Create a new migration at the given path.
     *
     * @param  string  $name
     * @param  string  $path
     * @param  string|null  $table
     * @param  bool  $create
     * @param  bool $klorchid_update true if the aim is to make a existent table comaptible with klorchid
     * @return string
     *
     * @throws \Exception
     */
    public function create($name, $path, $table = null, $create = false,$klorchid_update = false)
    {
        $this->ensureMigrationDoesntAlreadyExist($name, $path);

        // First we will get the stub file for the migration, which serves as a type
        // of template for the migration. Once we have those we will populate the
        // various place-holders, save the file, and run the post create event.
        $stub = $this->getKstub($table, $create,$klorchid_update);

        $path = $this->getPath($name, $path);

        $this->files->ensureDirectoryExists(dirname($path));

        $this->files->put(
            $path, $this->populateStub($name, $stub, $table)
        );

        // Next, we will fire any hooks that are supposed to fire after a migration is
        // created. Once that is done we'll be ready to return the full path to the
        // migration file so it can be used however it's needed by the developer.
        $this->firePostCreateHooks($table);

        return $path;
    }


     /**
     * Get the migration stub file.
     *
     * @param  string|null  $table
     * @param  bool  $create
     * @param  bool $klorchid_update true if the aim is to make a existent table comaptible with klorchid
     * @return string
     */
    protected function getKstub($table, $create, $klorchid_update)
    {
        if (is_null($table)) {
            $stub = $this->files->exists($customPath = $this->customStubPath.'/migration.stub')
                            ? $customPath
                            : $this->stubPath().'/migration.stub';
        } elseif ($create) {
            $stub = $this->files->exists($customPath = $this->customStubPath.'/migration.create.stub')
                            ? $customPath
                            : $this->stubPath().'/migration.create.stub';
        } elseif ($klorchid_update) {
            $stub = $this->files->exists($customPath = $this->customStubPath.'/migration.klorchidupdate.stub')
                            ? $customPath
                            : $this->stubPath().'/migration.klorchidupdate.stub';
        } else {
            $stub = $this->files->exists($customPath = $this->customStubPath.'/migration.update.stub')
                            ? $customPath
                            : $this->stubPath().'/migration.update.stub';
        }

        return $this->files->get($stub);
    }



}