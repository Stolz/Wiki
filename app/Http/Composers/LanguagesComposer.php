<?php

namespace App\Http\Composers;

use App\Language;
use Illuminate\Contracts\View\View;

class LanguagesComposer
{
	/**
	 * Bind data to the view.
	 *
	 * @param  View  $view
	 * @return void
	 */
	public function compose(View $view)
	{
		// Available languages
		$view->with('languages', $languages = Language::orderBy('name')->get());

		// Available languages but current one
		$appLanguage = app('language');
		$view->with('languagesButCurrent', $languages->filter(function ($l) use ($appLanguage) {
			return $l->id != $appLanguage->id;
		}));

		// All languages
		//$view->with('allLanguages', Language::orderBy('name')->withTrashed()->get());
	}
}
