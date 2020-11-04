<?php

declare(strict_types=1);

namespace Kamansoft\Klorchid\Console\Commands;

use Illuminate\Console\Command;
use Orchid\Platform\Dashboard;

//use Orchid\Platform\Events\InstallEvent;
use Kamansoft\Klorchid\KlorchidServiceProvider;
use Illuminate\Support\Facades\DB;

class KlorchidInstallCommand extends Command
{


    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'klorchid:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish files for KLORCHID and install package';

    /**
     * Execute the console command.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function handle(Dashboard $dashboard)
    {
        $this->info('Installation started. Please wait...');
        //$this->info('Version: '.Dashboard::VERSION);


        $this
            ->executeCommand('vendor:publish', [
                '--provider' => KlorchidServiceProvider::class,
                '--force' => true
            ])
            ->executeCommand('migrate')
            ->settingSystemUserEnvVars();
        //->executeCommand('storage:link')
        //->changeUserModel();


        $this->info('Completed!');

        $this->line("To start the embedded server, run 'artisan serve'");

        //event(new InstallEvent($this));
    }

    public function settingSystemUserEnvVars()
    {
        $user = $this->getSystemUser();
        if (!empty($user)) {
            $this
                ->setValueEnv('SYSTEM_USER_ID', strval($user->id))
                ->setValueEnv('SYSTEM_USER_NAME', $user->name)
                ->setValueEnv('SYSTEM_USER_EMAIL', $user->email);
            $this->info("Env var setted");
        } else {
            throw new \Exception('Cant find System user, instalation fail and can not continue');

        }
        return $this ;
    }

    public function getSystemUser()
    {
        $this->info(config('klorchid.system_user_name'));
        return DB::table('users')->where('name', config('klorchid.system_user_name'))->first();
    }

    /**
     * @param string $command
     * @param array $parameters
     *
     * @return $this
     */
    private function executeCommand(string $command, array $parameters = []): self
    {
        try {
            $result = $this->call($command, $parameters);
        } catch (\Exception $exception) {
            $result = 1;
            $this->alert($exception->getMessage());
        }

        if ($result) {
            $parameters = http_build_query($parameters, '', ' ');
            $parameters = str_replace('%5C', '/', $parameters);
            $this->alert("An error has occurred. The '{$command} {$parameters}' command was not executed");
        }

        return $this;
    }

    private function changeUserModel(string $path = 'Models/User.php')
    {
        $this->info('Attempting to set ORCHID User model as parent to App\User');

        if (!file_exists(app_path($path))) {
            $this->warn('Unable to locate "app/Models/User.php".  Did you move this file?');
            $this->warn('You will need to update this manually.');

            return;
        }


        $user = file_get_contents(Dashboard::path('stubs/app/User.stub'));
        file_put_contents(app_path($path), $user);
    }

    /**
     * @param string $constant
     * @param string $value
     *
     * @return InstallCommand
     */
    private function setValueEnv(string $constant, string $value = 'null'): self
    {
        $str = $this->fileGetContent(app_path('../.env'));

        if ($str !== false && strpos($str, $constant) === false) {
            file_put_contents(app_path('../.env'), $str . PHP_EOL . $constant . '=' . $value . PHP_EOL);
        }

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
