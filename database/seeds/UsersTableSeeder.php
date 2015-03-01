<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
	public function run()
	{
		$now = Carbon\Carbon::now();

		DB::table('users')->insert([
			[
				'uuid' => 1,
				'name' => 'Admin',
				'nickname' => 'admin',
				'email' => 'admin@example.com',
				'language_id' => 1,
				'provider_id' => 1,
				'role_id' => 1,
				'created_at' => $now,
				'updated_at' => $now
			],
		]);
	}
}
