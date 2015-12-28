<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class ViewComposerServiceProvider extends ServiceProvider
{
	/**
	 * Register view composers.
	 *
	 * @return void
	 */
	public function boot()
	{
		View::composers([
			// View composer class => View file (use an array for more than one)
			'App\Http\Composers\BaseLayoutComposer' => 'layouts.base',
			'App\Http\Composers\MasterLayoutComposer' => 'layouts.master',
			'App\Http\Composers\LanguagesComposer' => 'layouts.master',
			'App\Http\Composers\ProvidersComposer' => 'login',
		]);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
