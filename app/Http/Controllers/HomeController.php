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
