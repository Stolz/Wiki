<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateProviderRequest extends Request
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
			'name' => [_('Name'), 'required|max:255|unique:providers,name{excludeCurrentId}'],
		]);
	}
}
