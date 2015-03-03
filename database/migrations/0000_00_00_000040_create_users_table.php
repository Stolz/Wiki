<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {

			// Set the storage engine and primary key
			$table->engine = 'InnoDB';
			$table->increments('id');

			// Ordinary columns
			$table->string('uuid');
			$table->string('name')->nullable();
			$table->string('nickname')->nullable();
			$table->string('email')->nullable();
			$table->string('avatar')->nullable();
			$table->unsignedInteger('login_count')->default(0);

			// Foreign keys
			$table->unsignedInteger('language_id');
			$table->foreign('language_id')->references('id')->on('languages')->onUpdate('cascade')->onDelete('cascade');
			$table->unsignedInteger('provider_id');
			$table->foreign('provider_id')->references('id')->on('providers')->onUpdate('cascade')->onDelete('cascade');
			$table->unsignedInteger('role_id');
			$table->foreign('role_id')->references('id')->on('roles')->onUpdate('cascade')->onDelete('restrict');

			// Extra keys
			$table->unique(['uuid', 'provider_id']);
			$table->unique(['email', 'provider_id']);

			// Automatic columns
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}
}
