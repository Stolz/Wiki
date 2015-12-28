<?php

namespace App\Http\Requests;

class CreateCategoryRequest extends Request
{
	/**
	 * Class constructor.
	 *
	 * @param  array
	 * @return void
	 */
	public function __construct(array $rules = [])
	{
		parent::__construct([
			'parent_id' => [_('Parent'), 'integer|exists:categories,id'],
			'name' => [_('Name'), 'required|max:255'],
		]);
	}
}
