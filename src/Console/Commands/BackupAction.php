<?php

namespace Kamansoft\Klorchid\Console\Commands;

use Illuminate\Console\Command;

class BackupAction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

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
    public function backupShellCommand():string
    {
        return
            'date=`date -I`;
            path='.storage_path().'/app/db_backups/ ;
            mysqldump --no-tablespaces -u '.config('database.connections.mysql.username').' -p"'.config('database.connections.mysql.password').'" '.config('database.connections.mysql.database').' > $path/back_$date.sql;
            gzip -f $path/back_$date.sql'
        ;
    }




    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        exec($this->backupShellCommand(), $output, $return);
        //echo implode(" ",$output);
        return $return;
    }
}
