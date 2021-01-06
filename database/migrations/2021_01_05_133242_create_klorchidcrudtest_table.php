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

            $table->boolean('status')->default(1);
            $table->text('cur_status_reason')->nullable();
            $table->foreignId('updated_by')->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->boolean('status')->default(1);
            $table->text('cur_status_reason')->nullable();
            $table->timestamps();

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
