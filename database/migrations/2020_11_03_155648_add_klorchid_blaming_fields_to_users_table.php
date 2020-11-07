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
            $table->unsignedBigInteger('updated_by')->default($system_user_id);
            $table->unsignedBigInteger('created_by')->default($system_user_id);

        });
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_by')->default(null)->change();
            $table->unsignedBigInteger('created_by')->default(null)->change();
            //$table->foreignId('created_by')->constrained();
            //$table->foreign('updated_by')->references('id')->on('users');
            //$table->foreign('created_by')->references('id')->on('users');

        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('updated_by')->references('id')->on('users');
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

            $table->dropForeign('users_updated_by_foreign');
            $table->dropForeign('users_created_by_foreign');
            $table->dropColumn('updated_by');
            $table->dropColumn('created_by');

        });
    }
}
