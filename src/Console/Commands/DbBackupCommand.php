<?php

namespace Kamansoft\Klorchid\Console\Commands;

use Illuminate\Console\Command;

class DbBackupCommand extends Command
{
    const  BACKUP_PATH = '/app/db_backups/';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'klorchid:make:db-backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dumps the Database used by the applications';


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
     * backupShellCommands
     *
     * @return string
     */
    public function backupShellCommand(): string
    {
        return
            'date=`date +%d-%m-%Y--%H-%M-%S`;
            path=' . storage_path() . static::BACKUP_PATH . ' ;
            mysqldump --no-tablespaces -u ' . config('database.connections.mysql.username') . ' -p"' . config('database.connections.mysql.password') . '" ' . config('database.connections.mysql.database') . ' > $path/back_$date.sql;
            gzip -f $path/back_$date.sql';
    }


    /**
                                                                     * Execute the console command.'
     *
     * '
     * @return int
     */
    public function handle()
    {

        $concurrentDirectory = storage_path() . static::BACKUP_PATH;
        if (!is_dir($concurrentDirectory)) {
            if (!mkdir($concurrentDirectory) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
        }
        exec($this->backupShellCommand(), $output, $return);

        return $return;
    }
}
