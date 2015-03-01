<?php

use Illuminate\Database\Seeder;

class ProvidersTableSeeder extends Seeder
{
	public function run()
	{
		$now = Carbon\Carbon::now();

		DB::table('providers')->insert([
			['id' => 1, 'name' => 'Facebook', 'slug' => 'facebook', 'created_at' => $now, 'updated_at' => $now],
			['id' => 2, 'name' => 'Twitter',  'slug' => 'twitter',  'created_at' => $now, 'updated_at' => $now],
			['id' => 3, 'name' => 'Google',   'slug' => 'google',   'created_at' => $now, 'updated_at' => $now],
			['id' => 4, 'name' => 'GitHub',   'slug' => 'github',   'created_at' => $now, 'updated_at' => $now],
		]);
	}
}
