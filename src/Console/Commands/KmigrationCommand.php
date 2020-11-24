<?php

namespace Kamansoft\Klorchid\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Console\Migrations\MigrateMakeCommand;
use Closure;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\Composer;
class KmigrationCommand extends MigrateMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'klorchid:migration {name : The name of the migration}
        {--create= : The table to be created}
        {--table= : The table to migrate}
        {--path= : The location where the migration file should be created}
        {--realpath : Indicate any provided migration file paths are pre-resolved absolute paths}
        {--fullpath : Output the full path of the migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(MigrationCreator $migrationCreator, Composer $composer)
    {
        parent::__construct(
            new MigrationCreator(
                $migrationCreator->getFilesystem(),
                __DIR__ . '/../../resources/stubs'), $composer);


    }







}
