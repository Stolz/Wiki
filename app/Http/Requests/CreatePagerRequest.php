<?php

namespace App\Http\Requests;

class CreatePageRequest extends Request
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
			'category_id' => [_('Category'), 'integer|exists:categories,id'],
			'name' => [_('Name'), 'required|max:255'],
			'source' => [_('Content'), 'required'],
		]);
	}
}
