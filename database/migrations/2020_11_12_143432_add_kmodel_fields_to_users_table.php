<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKmodelFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean(config('klorchid.models_common_field_names.status'))->default(1);
            $table->text(config('klorchid.models_common_field_names.reason'))->nullable();
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
            $table->dropColumn(config('klorchid.models_common_field_names.status'));
            $table->dropColumn(config('klorchid.models_common_field_names.reason'));
        });
    }
}
