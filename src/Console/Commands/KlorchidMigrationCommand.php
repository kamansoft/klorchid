<?php

namespace Kamansoft\Klorchid\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Console\Migrations\BaseCommand;
use Illuminate\Database\Console\Migrations\MigrateMakeCommand;
use Illuminate\Database\Console\Migrations\TableGuesser;
use Closure;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Kamansoft\Klorchid\Database\Migrations\KlorchidMigrationCreator;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\Schema;
use Kamansoft\Klorchid\Console\Commands\KlorchidModelCommand;

class KlorchidMigrationCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'klorchid:migration {name : The name of the migration}
        {--table= : The table to migrate}
        {--create= : The table to be created}
        {--adapt= : The non empty, already existent table to add klorchid fields}
        {--timestamps-add= : The table to add laravel timestamps}
        {--status-type= : Specify The type of model based on status: [ ' . KlorchidModelCommand::BOOLEAN_BINARY . ' (default), ' . KlorchidModelCommand::INTEGER_MULTI . ', ' . KlorchidModelCommand::STRING_MULTI . ' ]  }
        {--path= : The location where the migration file should be created}
        {--realpath : Indicate any provided migration file paths are pre-resolved absolute paths}
        {--fullpath : Output the full path of the migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new klorchid binary state model compatible migration file for a table';

    /**
     * The migration creator instance.
     *
     * @var \Kamansoft\Klorchid\Database\Migrations\KlorchidMigrationCreator
     */
    protected $creator;

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * Create a new migration install command instance.
     *
     * @param \Kamansoft\Klorchid\Database\Migrations\KlorchidMigrationCreator $creator
     * @param \Illuminate\Support\Composer $composer
     * @return void
     */
    public function __construct(KlorchidMigrationCreator $creator, Composer $composer)
    {
        parent::__construct();

        $this->creator = $creator;
        $this->composer = $composer;
    }


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // It's possible for the developer to specify the tables to modify in this
        // schema operation. The developer may also specify if this table needs
        // to be freshly created so we can create the appropriate migrations.
        $name = Str::snake(trim($this->input->getArgument('name')));

        $table = $this->input->getOption('table');

        $action = "update";


        $create = $this->input->getOption('create') ?: false;

        $klorchid_adapt = $this->input->getOption('adapt') ?: false;

        $add_timestamps = $this->input->getOption('timestamps-add') ?: false;


        $this->line("<info>The options: create, adapt, and timestamps-add, are mutually exclusive. You can only run one at time</info>");


        // If no table was given as an option but a create option is given then we
        // will use the "create" option as the table name. This allows the devs
        // to pass a table name into this option as a short-cut for creating.
        if (!$table && is_string($create)) {
            $table = $create;
            $action = 'create';
        } elseif (!$table && is_string($klorchid_adapt)) {
            $table = $klorchid_adapt;
            $action = "adapt";
        } elseif (!$table && is_string($add_timestamps)) {
            $table = $add_timestamps;
            $action = "timestamps-add";
        }


        // Next, we will attempt to guess the table name if this the migration has
        // "create" in the name. This will allow us to provide a convenient way
        // of creating migrations that create new tables for the application.
        if (!$table) {
            [$table, $create] = TableGuesser::guess($name);
            if ($create) {
                $action = "create";
            } else {
                $action = "update";
            }

        }

        if ($action !== 'create') {
            if (!Schema::hasTable($table)) {
                throw new \Exception(' Unable to find "' . $table . '" table for "' . $action . '" action  in your database');
            }
        }


        $status_field = '';


        //
        if ($this->input->getOption('status-type') === KlorchidModelCommand::BOOLEAN_BINARY) {
            $status_field = '$table->boolean(config(\'klorchid.models_common_field_names.status\'))->default(1);';
        } elseif ($this->input->getOption('status-type') === KlorchidModelCommand::INTEGER_MULTI) {
            $status_field = '$table->integer(config(\'klorchid.models_common_field_names.status\'));';
        } elseif ($this->input->getOption('status-type') === KlorchidModelCommand::STRING_MULTI) {
            $status_field = '$table->string(config(\'klorchid.models_common_field_names.status\'));';
        }

        $this->line("<info>A {$action} migration file for {$table} table is about to be created.</info>");


        // Now we are ready to write the migration out to disk. Once we've written
        // the migration out, we will dump-autoload for the entire framework to
        // make sure that the migrations are registered by the class loaders.
        $this->writeMigration($name, $action, $table, $status_field);

        $this->composer->dumpAutoloads();
    }


    /**
     * Write the migration file to disk.
     * @param $name
     * @param $action
     * @param $table
     */
    protected
    function writeMigration($name, $action, $table, $status = null)
    {

        $file = $this->creator->create(
            $name, $this->getMigrationPath(), $action, $table, $status
        );

        if (!$this->option('fullpath')) {
            $file = pathinfo($file, PATHINFO_FILENAME);
        }

        $this->line("<info>Created Klorchid migration:</info> {$file}");
    }

    /**
     * Get migration path (either specified by '--path' option or default location).
     *
     * @return string
     */
    protected
    function getMigrationPath()
    {
        if (!is_null($targetPath = $this->input->getOption('path'))) {
            return !$this->usingRealPath()
                ? $this->laravel->basePath() . '/' . $targetPath
                : $targetPath;
        }

        return parent::getMigrationPath();
    }


}
