<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('key',100)->unique();
            $table->string('value',255)->nullable();
            $table->text('description')->nullable();
            $table->foreignId(config('klorchid.models_common_field_names.last_updater'))->constrained('users');
            $table->foreignId(config('klorchid.models_common_field_names.creator'))->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_settings');
    }
}
