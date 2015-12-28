<?php

namespace App\Http\Composers;

use Assets;
use Cache;
use Carbon\Carbon;
use File;
use Illuminate\Contracts\View\View;

class BaseLayoutComposer
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

		// Application language
		$view->with('appLanguage', app('language'));

		// Add debugbar if it's enabled
		if(app()->bound('debugbar') and config('debugbar.enabled', false))
		{
			Assets::add('debugbar');
			$renderer = app('debugbar')->getJavascriptRenderer();

			// Dinamically generate DebugBar assets every 7 days
			$lastTimeAssetsWereGenerated = Cache::remember('debugbar', 60 * 24 * 7, function() use ($renderer) {
				File::put(public_path('css/debugbar.css'), $renderer->dumpAssetsToString('css') . 'div.phpdebugbar ul,div.phpdebugbar ol,div.phpdebugbar dl {font-size: 100%;}');
				File::put(public_path('js/debugbar.js'), $renderer->dumpAssetsToString('js'));
				return Carbon::now()->toDateString();
			});

			$view->with('debug', $renderer->render());
		}
	}
}
