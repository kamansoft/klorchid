<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKlorchidBlamingFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('users', function (Blueprint $table) {

            $system_user_id = config('klorchid.system_user_id');
            $table->unsignedBigInteger(config('klorchid.models_common_field_names.last_updater'))->default($system_user_id);
            $table->unsignedBigInteger(config('klorchid.models_common_field_names.creator'))->default($system_user_id);

        });
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger(config('klorchid.models_common_field_names.last_updater'))->default(null)->change();
            $table->unsignedBigInteger(config('klorchid.models_common_field_names.creator'))->default(null)->change();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign(config('klorchid.models_common_field_names.last_updater'))->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign('users_'.config('klorchid.models_common_field_names.last_updater').'_foreign');
            $table->dropForeign('users_'.config('klorchid.models_common_field_names.creator').'_foreign');
            $table->dropColumn(config('klorchid.models_common_field_names.last_updater'));
            $table->dropColumn('created_by');

        });
    }
}
