<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
	public function run()
	{
		$now = Carbon\Carbon::now();

		DB::table('languages')->insert([
			['id' => 1, 'code' => 'en', 'name' => 'English', 'native_name' => 'English', 'locale' => 'en_US', 'is_default' => 1, 'created_at' => $now, 'updated_at' => $now],
			['id' => 2, 'code' => 'es', 'name' => 'Spanish', 'native_name' => 'Español', 'locale' => 'es_ES', 'is_default' => 0, 'created_at' => $now, 'updated_at' => $now],
		]);
	}
}
