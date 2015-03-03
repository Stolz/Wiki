<?php namespace App\Http\Controllers;

use App\Http\Requests\SocialLoginRequest;
use App\Provider;
use App\User;
use Auth;
use Config;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Input;
use Laravel\Socialite\Contracts\User as SocialUser;
use Session;
use Socialite;
use URL;

class AuthController extends Controller
{
	/**
	 * Show login form
	 *
	 * @return Response
	 */
	public function showLoginPage()
	{
		return view('login')->withTitle(_('Login'));
	}

	/**
	 * Attempt to log in an user using a social authentication provider.
	 *
	 * @param  string
	 * @return Response
	 */
	public function loginWithProvider($providerSlug)
	{
		// If the remote provider sends an error cancel the process
		foreach(['error', 'error_message', 'error_code'] as $error)
			if(Input::has($error))
				return $this->goBack(_('Something went wrong') . '. ' . Input::get($error));

		// Get provider
		$provider = Provider::whereSlug($providerSlug)->firstOrFail();

		// Make sure it's usable
		if( ! $provider->isUsable())
			return $this->goBack(_('Unavailable provider'));

		// Set provider callback url
		Config::set("services.{$provider->slug}.redirect", URL::current());

		// Create an Oauth service for this provider
		$oauthService = Socialite::with($provider->slug);

		// If this is a callback from the provider the user information
		// should be available, otherwise an exception will be thrown
		try
		{
			if($user = $oauthService->user())
				return $this->loginSocialUser($provider, $user);
		}
		catch(\InvalidArgumentException $e)
		{
			// This is not a callback request.
			// Redirect user to authorize our App.
			if($scopes = config("services.{$provider->slug}.scopes"))
				$oauthService->scopes($scopes);

			return $oauthService->redirect();
		}
	}

	/**
	 * Handle callback from provider.
	 *
	 * It creates/gets the user and logs him/her in.
	 *
	 * @param  \App\Provider
	 * @param  \Laravel\Socialite\Contracts\User
	 * @return Response
	 */
	protected function loginSocialUser(Provider $provider, SocialUser $socialUser)
	{
		// Validate response
		$errors = with(new SocialLoginRequest)->validate($socialUser);
		if($errors->any())
		{
			$providerError = sprintf(_('There are problems with data provided by %s'), $provider);

			return $this->goBack($providerError . ': ' . implode(', ', $errors->all()));
		}

		// Get/create user matching social user
		$user = User::findOrCreate($provider, $socialUser);

		// If user has been disabled disallow login
		if($user->trashed())
			return $this->goBack(_('Your account has been disabled'));

		// Login user
		Auth::login($user);

		return redirect()->intended(route('home'));
	}

	/**
	 * Log out the current user
	 *
	 * @return Response
	 */
	public function logout()
	{
		Auth::logout();

		return redirect()->route('home');
	}

	/**
	 * Redirect back flashing error to session.
	 *
	 * @param  string
	 * @return Response
	 */
	protected function goBack($error)
	{
		Session::flash('error', $error);

		return redirect()->back();
	}
}
