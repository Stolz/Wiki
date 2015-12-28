<?php

namespace App\Http\Requests;

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
			'uuid' => [_('Remote ID'), 'required|max:255'],
			'name' => [_('Name'), 'max:255'],
			'nickname' => [_('Nickname'), 'max:255'],
			'email' => [_('E-mail'), 'max:255|email'],
			'avatar' => [_('Avatar'), 'max:255|url'],
			//'verified' => ['not used', 'required|same:require_verified'],
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

			// Require that the account has been verified by the provider
			//'require_verified' => true,
			//'verified' => $socialUser->offsetGet('verified'),
		];

		$customMessages = ['same' => _('Your account is not verified')];

		return Validator::make($input, $this->rules, $customMessages)->setAttributeNames($this->labels)->errors();
	}
}
