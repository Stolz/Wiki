<?php namespace App\Providers;

use Baum\BaumServiceProvider as ServiceProvider;

/**
 * The package Baum still uses Laravel 4 service provider.
 * This is a workaround until a a Laravel 5 version is released.
 *
 * TODO When this workaround in no longed needed delete this file and restore the original path in config/app.php
 */

class BaumServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// If the boot method does nothing Baum can be used in Laravel 5 :)
	}
}
