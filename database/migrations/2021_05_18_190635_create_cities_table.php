<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            //$table->id();

            //add your fields here
            $table->foreignUuid('state_id')->constrained();
            $table->string('name');

            //common fields to be used on klorchid based apps
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->boolean(config('klorchid.models_common_field_names.status'))->default(1);
            $table->text(config('klorchid.models_common_field_names.reason'))->nullable();
            $table->foreignId(config('klorchid.models_common_field_names.creator'))->constrained('users');
            $table->foreignId(config('klorchid.models_common_field_names.last_updater'))->constrained('users');
            $table->unique('name','state_id');

            // \common fields to be used on klorchid based apps

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
