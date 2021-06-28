<?php

namespace Kamansoft\Klorchid\Console\Commands;

use Illuminate\Console\Command;
use  App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Kamansoft\Klorchid\Console\Commands\KlorchidInstallCommand;
use Kamansoft\Klorchid\KlorchidServiceProvider;
use Kamansoft\Klorchid\Models\Kuser;

class SystemUserAddCommand extends Command
{
    public static $system_user_id_const_name = 'SYSTEM_USER_ID';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'klorchid:systemuser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add the system user needed for klorchid';

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

        $this->info('Running klorchid:systemuser command');

        //check if exist SYSTEM_USER_ID constant in env file
        if ($this->envConstantExists(self::$system_user_id_const_name)) {
            $this->info(self::$system_user_id_const_name . ' already seted with value: ' . config('klorchid.system_user_id'));
            $setted_sys_user_id = config('klorchid.system_user_id');
            $user = $this->handleUser($setted_sys_user_id);

        } else {

            $this->info(self::$system_user_id_const_name . ' not setted');
            $user = $this->handleUser();
            $this->setValueEnv(self::$system_user_id_const_name, $user->id);
        };


        return 0;
    }

    protected function checkMigration(string $migration_name): bool
    {
        $hasRun = DB::table('migrations')->where('migration', $migration_name)->exists();
        return $hasRun;
    }

    /**
     * Retrives the next autoincrement on a mysql table
     *
     * @return mixed
     */
    protected function getMysqlAutoIncrement()
    {
        $next = DB::table('INFORMATION_SCHEMA.TABLES')
            ->select('AUTO_INCREMENT')
            ->where([
                'TABLE_SCHEMA' => config('database.connections.mysql.database'),
                'TABLE_NAME' => 'users'
            ])->first();
        return $next->AUTO_INCREMENT;
    }


    protected function handleUser($id = null): User
    {
        $user = new User();
        $user->name = 'system';
        $user->email = 'system@' . config('app.name');

        if (!empty($id)) {
            try {
                $user = User::findOrfail($id);
            } catch (Exception $e) {

                Log::error('The user specified on .env file or config at SYSTE_USER_ID was not found on DB. ' . $e->getMessage());
                Log::info('attempt to create a system user id with SYSTE_USER_ID=' . $id . ' value from .env file ');

                //throw  new Exception('The user specified on .env file or config at SYSTE_USER_ID was not found on DB. ' . $e->getMessage());


            }
        } else {

            $user->id = $id;
        }


        $user->password = '';

        try {
            if ($this->checkMigration(KlorchidServiceProvider::$blaming_fields_migration_filename)) {
                DB::transaction(function () use ($user) {
                    $user->updated_by = $user->created_by = $this->getMysqlAutoIncrement();
                    $user->save();
                });
            } else {
                $user->save();
            }
        } catch (Exception $e) {
            Log::error('System User insertion Fail');
            Log::error($e->getMessage());

            throw  new Exception('The user was not inserted on the database' . $e->getMessage());
        }


        return $user;


    }


    private function envConstantExists(string $constant): bool
    {
        $str = $this->fileGetContent(app_path('../.env'));
        return !($str !== false && strpos($str, $constant) === false);
    }

    /**
     * @param string $constant
     * @param string $value
     *
     * @return InstallCommand
     */
    private function setValueEnv(string $constant, string $value = 'null'): self
    {
        $this->info("Atempt to set $constant=$value to .env file");
        $str = $this->fileGetContent(app_path('../.env'));

        if ($str !== false && strpos($str, $constant) === false) {
            file_put_contents(app_path('../.env'), $str . PHP_EOL . $constant . '=' . $value . PHP_EOL);
        } else {
            throw new Exception('Cant add ' . $constant . ' entry on projects .env  file you must  remove it  by hand');
        }

        $this->info("Constant successfully added to file");
        return $this;
    }

    /**
     * @param string $file
     *
     * @return false|string
     */
    private function fileGetContent(string $file)
    {
        if (!is_file($file)) {
            return '';
        }

        return file_get_contents($file);
    }
}
