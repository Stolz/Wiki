<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		// Clear cache
		Artisan::call('cache:clear');

		// Seed
		$this->call('LanguagesTableSeeder');
		$this->call('ProvidersTableSeeder');
		$this->call('RolesTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('CategoriesTableSeeder');
		$this->call('PagesTableSeeder');
	}
}
