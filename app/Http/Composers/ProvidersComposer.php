<?php

namespace App\Http\Composers;

use App\Provider;
use Illuminate\Contracts\View\View;

class ProvidersComposer
{
	/**
	 * Bind data to the view.
	 *
	 * @param  View  $view
	 * @return void
	 */
	public function compose(View $view)
	{
		// Available providers
		//$view->with('providers', Provider::orderBy('name')->get());

		// All providers
		//$view->with('allProviders', Provider::orderBy('name')->withTrashed()->get());

		// Usable providers
		$view->with('usableProviders', Provider::getUsable());
	}
}
