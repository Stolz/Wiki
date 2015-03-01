<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
	public function run()
	{
		$now = Carbon\Carbon::now();

		DB::table('roles')->insert([
			['id' => 1, 'name' => 'User', 'is_default' => 1, 'created_at' => $now, 'updated_at' => $now],
		]);
	}
}
