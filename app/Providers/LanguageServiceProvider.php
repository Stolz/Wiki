<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LanguageServiceProvider extends ServiceProvider
{
	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		// Database is not available on this early stage.
		// Define a fallback application language.
		$this->app->singleton('language', function() {

			$language = [
				'id' => 1,
				'code' => 'en',
				'name' => 'English',
				'native_name' => 'English',
				'locale' => 'en_US',
				'is_default' => true
			];

			return (object) $language;
		});
	}

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Database is now available.
		// Replace previous binding with an actual model instance.
		$this->app->singleton('language', function() {

			return \App\Language::detect()->apply();
		});
	}
}
