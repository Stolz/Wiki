<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateUserRequest extends Request
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
			'uuid' => [_('Remote id'), 'required|max:255'], //TODO hacer unique con provider_id
			'name' => [_('Name'), 'max:255'],
			'nickname' => [_('Nickname'), 'max:255'],
			'email' => [_('E-mail'), 'required|max:255|email'],//TODO hacer unique con provider_id
			'avatar' => [_('Avatar'), 'max:255|url'],

			// Relationships
			'language_id' => [_('Language'), 'required|integer|exists:languages,id'],
			'provider_id' => [_('Provider'), 'required|integer|exists:providers,id'],
			'role_id' => [_('Role'), 'required|integer|exists:roles,id'],
		]);
	}
}
