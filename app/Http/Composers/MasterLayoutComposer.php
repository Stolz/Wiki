<?php namespace App\Http\Composers;

use Auth;
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
		$view->with('currentUser', Auth::user());

		// Navigation sections
		$sections = [
			'category.index' => _('Categories'),
			'language.index' => _('Languages'),
			'page.index' => _('Pages'),
			'provider.index' => _('Providers'),
			'role.index' => _('Roles'),
			'user.index' => _('Users'),
		];
		asort($sections);
		$view->with('sections', $sections);
	}
}
