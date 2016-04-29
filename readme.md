# [Wiki](https://github.com/Stolz/Wiki)

A simple PHP wiki engine.

## Features

- Backend based on [Laravel 5.1](http://laravel.com) PHP framework. The code has a minimal footprint which makes the application very easy to customize to your needs.
- Frontend based on [Zurb Foundation](http://foundation.zurb.com) CSS framework which gives a clean responsive layout and a mobile-friendly user experience.
- Pages are written in [Markdown](http://en.wikipedia.org/wiki/Markdown) with live preview of the final markup.
- User authentication/registration with one click via Oauth providers (Facebook, GitHub, Google and Twitter).
- Multilanguage support via Gettext.
- Included boilerplate to implement your own custom permissions system based on user roles.

## Caveats

This project is not intended to be a mass distributed real world application but rather to server as a proof-of-concept and showcase of different technologies and concepts I enjoy using ([RESTful architecture](http://en.wikipedia.org/wiki/Representational_state_transfer), [Dependency Injection](http://en.wikipedia.org/wiki/Dependency_injection), [Responsive design](http://en.wikipedia.org/wiki/Responsive_web_design), [SOLID principles](http://en.wikipedia.org/wiki/SOLID_%28object-oriented_design%29), ...). Nevertheless it's being implemented to be 100% usable in real scenarios.

## Install

Via git

	git clone https://github.com/Stolz/Wiki.git --depth 1 wiki && cd wiki && composer install


Via composer

	composer create-project stolz/wiki --prefer-dist --stability=dev --no-scripts && cd wiki

Once the project is installed configure it as [any other Laravel app](https://laravel.com/docs/5.1/installation#configuration)

	$EDITOR .env
	$EDITOR config/app.php
	php artisan migrate --seed

## Customizing permissions

Trying to perform an action (create, update, delete, ...) on any of the wiki resources (users, pages, categories, ...) will trigger the `can()` method on the `app/Role.php` file with the corresponding action and resouce parameters.

The default implementation of the function is very relaxed and allows all user roles to perform all action on all resources.

	/**
	 * Determine if $this role is authorized to execute $action on $resource.
	 *
	 * @param  string $action
	 * @param  string $resource
	 * @return bool
	 */
	public function can($action, $resource)
	{
		return true;
	}

To customize which actions can perform each user role you only need to add your logic to this method. A silly example could be:

	// file: app/Role.php
	public function can($action, $resource)
	{
		$currentUserProfile = $this->name;

		// Admin role has no restrictions
		if ($currentUserProfile === 'admin')
			return true;

		// Relaxed read permissions for all roles
		if($action === 'index' or $action === 'show')
			return true;

		// Editor role can edit pages
		if ($currentUserProfile === 'editor' and $resouce === 'page' and $action === 'edit')
			return true;

		// Manager role has full access to categories
		if ($currentUserProfile === 'manager' and $resouce === 'category')
			return true;

		return false;
	}

If you still want a more advanced permissions system feel free to fully replace the `Permissions` middleware located at `app/Http/Middleware/Permissions.php`.

## License

MIT license. Check the included [LICENSE.txt](https://github.com/Stolz/Wiki/blob/master/LICENSE.txt) file for details.

(c) [Stolz](https://github.com/Stolz).
