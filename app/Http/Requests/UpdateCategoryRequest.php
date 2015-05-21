<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateCategoryRequest extends Request
{
	/**
	 * Class constructor.
	 *
	 * @param  array
	 * @return void
	 */
	public function __construct($rules = [])
	{
		parent::__construct([
			'parent_id' => [_('Parent'), 'integer|exists:categories,id|different:id'],
			'name' => [_('Name'), 'required|max:255'],
		]);
	}
}
