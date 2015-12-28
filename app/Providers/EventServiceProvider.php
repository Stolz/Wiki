<?php

namespace App\Providers;

use App\Language;
use App\User;
use Event;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Session;

class EventServiceProvider extends ServiceProvider
{
	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		'App\Events\SomeEvent' => [
			'App\Listeners\EventListener',
		],
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		parent::boot($events);

		Event::listen('language.change', function (Language $language) {
			// Change application language
			$language->apply()->remember();

			// Update user's language
			if($user = auth()->user())
				$user->language()->associate($language)->save();

			// Feedback
			Session::flash('success', sprintf(_('Language changed to %s'), $language->native_name));
		});

		Event::listen('auth.login', function (User $user) {
			// Change application language to current user's language
			if($user->language instanceof Language)
				$user->language->apply()->remember();

			// Stats
			$user->increment('login_count');
			$user->provider->increment('login_count');

			// Feedback
			Session::flash('success', sprintf(_('Logged in as %s'), $user));
		});

		Event::listen('auth.logout', function (User $user) {

			// Feedback
			Session::flash('success', _('Logged out'));

			// Reset default application language
			Language::forget();
		});
	}
}
