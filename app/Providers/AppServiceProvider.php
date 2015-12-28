<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		// Load environment Specific Service Providers...
		if($this->app->environment('local'))
		{
			$providers = [
				\Barryvdh\Debugbar\ServiceProvider::class,
				\Spatie\Tail\TailServiceProvider::class,
				\Stolz\HtmlTidy\ServiceProvider::class,
			];

			foreach($providers as $provider)
				$this->app->register($provider);
		}
	}
}
