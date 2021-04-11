<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKlorchidAvatarColumnToUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('users', function (Blueprint $table) {
			$table->Integer('kavatar')->nullable()->unsigned();
			$table->foreign('kavatar')->references('id')->on('attachments')->onDelete('cascade');
			//
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('users', function (Blueprint $table) {
			$table->dropForeign('users_kavatar_foreign');
			$table->dropColumn('kavatar');
			//

		});
	}
}
