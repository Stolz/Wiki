<?php

use App\Category;
use App\Page;
use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
	public function run()
	{
		// Get the categories subtree of the first root category
		$categories = Category::roots()->first()->getDescendantsAndSelf();

		// Pretend first ser has logged in
		auth()->loginUsingId($i = 1);

		// Add a page for each category of the subtree
		foreach($categories as $category)
		{
			Page::create([
				'name' => "Page $i",
				'source' => "Content of page $i",
				'category_id' => $category->id,
			]);

			$i++;
		}
	}
}
