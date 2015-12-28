<?php

namespace App\Http\Requests;

class CreateUserRequest extends Request
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
			'uuid' => [_('Remote id'), 'required|max:255|unique_with:users,provider_id{excludeCurrentId}'],
			'name' => [_('Name'), 'max:255'],
			'nickname' => [_('Nickname'), 'max:255'],
			'email' => [_('E-mail'), 'max:255|email|unique_with:users,provider_id{excludeCurrentId}'],
			'avatar' => [_('Avatar'), 'max:255|url'],
			'language_id' => [_('Language'), 'required|integer|exists:languages,id'],
			'provider_id' => [_('Provider'), 'required|integer|exists:providers,id'],
			'role_id' => [_('Role'), 'required|integer|exists:roles,id'],
		]);
	}
}
