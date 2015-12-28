<?php

namespace App\Http\Composers;

use Illuminate\Contracts\View\View;

class MasterLayoutComposer
{
	/**
	 * Bind data to the view.
	 *
	 * @param  View  $view
	 * @return void
	 */
	public function compose(View $view)
	{
		// Application name
		$view->with('appName', config('app.name'));

		// Current authenticated user
		$view->with('currentUser', $user = auth()->user());

		if( ! $user)
			return;

		// Navigation sections
		$sections = [
			'category' => _('Categories'),
			'language' => _('Languages'),
			'page'     => _('Pages'),
			'provider' => _('Providers'),
			'role'     => _('Roles'),
			'user'     => _('Users'),
		];

		// Filter out unauthorized sections
		$sections = array_filter($sections, function ($section) use ($user) {
			return $user->can('index', $section);
		});

		// Natural sort
		natcasesort($sections);
		$view->with('sections', $sections);
	}
}
