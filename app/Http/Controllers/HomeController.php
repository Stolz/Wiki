<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
	/**
	 * Show home page.
	 * If the user is already logged in, show categories, otherwise show README.
	 *
	 * @return Response
	 */
	public function showHomePage()
	{
		if(auth()->check())
			return redirect(route('category.index'));

		$readme = markup(\File::get(base_path('readme.md')));

		return view('home')->withTitle(_('Home'))->withContent($readme);
	}

	/**
	 * Change the application language.
	 *
	 * @param  string
	 * @return Response
	 */
	public function changeApplicationLanguage($code)
	{
		if($language = \App\Language::whereCode($code)->first())
			event('language.change', $language);

		return redirect(\URL::previous() ?: route('home'));
	}
}
