<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKlorchidcrudtestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klorchidcrudtest', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();

            $table->boolean(config('klorchid.models_common_field_names.status'))->default(1);
            $table->text(config('klorchid.models_common_field_names.reason'))->nullable();
            $table->foreignId(config('klorchid.models_common_field_names.last_updater'))->constrained('users');
            $table->foreignId(config('klorchid.models_common_field_names.creator'))->constrained('users');
            $table->timestamps();qs

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('klorchidcrudtest');
    }
}
