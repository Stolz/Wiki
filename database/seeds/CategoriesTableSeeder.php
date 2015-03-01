<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
	public function run()
	{
		// Helper function to populate model attributes
		$node = function () {
			$args = implode(' ', func_get_args());

			return ['name' => "Category $args"];
		};

		// Create first level nodes
		foreach(range('A', 'F') as $letter)
		{
			$node0 = Category::create($node($letter));

			// Create second level nodes
			foreach(range(1, 3) as $number)
			{
				$node1 = $node0->children()->create($node($letter, $number));

				// Create third level nodes
				foreach(['Δ', 'Σ', 'Ω'] as $greek)
				{
					$node2 = $node1->children()->create($node($letter, $number, $greek));
				}
			}
		}
	}
}
