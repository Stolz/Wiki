<?php

/** ============ NEUTRAL AREA ============ */

// Main page
get('/', ['as' => 'home', 'uses' => 'HomeController@showHomePage']);

// Change current language
get('lang/{code}', ['as' => 'language.set', 'uses' => 'HomeController@changeApplicationLanguage']);

/** ============ ONLY GUESTS AREA ============ */

Route::group(['https', 'middleware' => 'guest'], function () {

	// Login page
	get('login', ['as' => 'login', 'uses' => 'AuthController@showLoginPage']);

	// Login with social provider
	get('login/{provider}', ['as' => 'login.with', 'uses' => 'AuthController@loginWithProvider']);
});

/** ============ ONLY AUTHENTICATED USERS AREA ============ */

Route::group(['https', 'middleware' => 'auth'], function () {

	// Logout
	get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);

	/** ============ ONLY GRANTED USERS AREA ============ */

	Route::group(['middleware' => 'permissions'], function () {

		// RESTful resources
		Route::resource('category', 'CategoryController');
		Route::resource('language', 'LanguageController');
		Route::resource('page', 'PageController');
		Route::resource('page.version', 'VersionController', ['only' => ['index', 'show']]);
		Route::resource('provider', 'ProviderController');
		Route::resource('role', 'RoleController');
		Route::resource('user', 'UserController');

	});
});
