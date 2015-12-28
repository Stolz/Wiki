<?php

namespace App\Http\Requests;

class CreateRoleRequest extends Request
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
			'name' => [_('Name'), 'required|max:255|unique:roles,name{excludeCurrentId}'],
			'is_default' => [_('Default'), 'required|integer|min:0|max:1'],
		]);
	}
}
