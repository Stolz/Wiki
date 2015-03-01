<?php namespace App\Http\Controllers;

class HomeController extends Controller
{
	/**
	 * Show home page.
	 *
	 * @return Response
	 */
	public function showHomePage()
	{
		return view('home')->withTitle(_('Home'));
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
