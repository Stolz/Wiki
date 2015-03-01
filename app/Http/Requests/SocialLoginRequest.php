<?php namespace App\Http\Requests;

use Laravel\Socialite\Contracts\User as SocialUser;
use Validator;

class SocialLoginRequest
{
	/**
	 * Class constructor.
	 *
	 * @param  array
	 * @return void
	 */
	public function __construct()
	{
		$rules = [
			// TODO make unique(['uuid', 'provider_id']
			'uuid' => [_('Remote ID'), 'required|max:255'],
			'name' => [_('Name'), 'max:255'],
			'nickname' => [_('Nickname'), 'max:255'],
			'email' => [_('E-mail'), 'required|max:255|email'],
			'avatar' => [_('Avatar'), 'max:255|url'],
		];

		list($this->labels, $this->rules) = Request::parseRulesAndLabels($rules);
	}

	/**
	 * Validate data from a social provider.
	 *
	 * @param  \Laravel\Socialite\Contracts\User
	 * @return \Illuminate\Contracts\Support\MessageProvider
	 */
	public function validate(SocialUser $socialUser)
	{
		$input = [
			'uuid' => $socialUser->getId(),
			'name' => $socialUser->getName(),
			'nickname' => $socialUser->getNickname(),
			'email' => $socialUser->getEmail(),
			'avatar' => $socialUser->getAvatar(),
		];

		return Validator::make($input, $this->rules)->setAttributeNames($this->labels)->errors();
	}
}
