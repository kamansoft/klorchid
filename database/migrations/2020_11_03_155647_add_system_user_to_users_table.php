<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kamansoft\Klorchid\Console\Commands\KlorchidInstallCommand;

class AddSystemUserToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //$user_id = config('klorchid.system_user_id');//env('SYSTEM_USER_ID', '1');
        $user_name = config('klorchid.system_user_name');//env('SYSTEM_USER_NAME', 'System');
        $user_email = config('klorchid.system_user_email');//env('SYSTEM_USER_EMAIL', '@');

        DB::table('users')->insert(
            array(
                //'id' => $user_id,
                'name' => env('SYSTEM_USER_NAME', $user_name),
                'email' => env('SYSTEM_USER_EMAIL', $user_email),
                'password' => '',
                'created_at' => now(),
                'updated_at' => now()

            )
        );


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $user_id = config('klorchid.system_user_id');//env('SYSTEM_USER_ID', '1');
        try {
            DB::table('users')->delete($user_id);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("cant delete system user. " . $e->getMessage());
            echo "cant delete system user. " . $e->getMessage();
        };
    }
}
