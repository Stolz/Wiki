<?php

return [
	'autoload' => ['foundation'],
	'public_dir' => public_path(),
	'collections' => [

		// Zurb Foundation
		'foundation' => ['foundation.css', 'foundation.js', 'app.js'],

		// PHP debugbar https://github.com/barryvdh/laravel-debugbar
		'debugbar' => ['debugbar.css', 'debugbar.js'],

		// jQuery 2.x (CDN)
		'jquery2-cdn' => ['//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js'],

		// Zurb Foundation (CDN)
		'foundation-cdn' => [
			'jquery2-cdn',
			'//cdn.jsdelivr.net/foundation/5.5.1/css/normalize.css',
			'//cdn.jsdelivr.net/foundation/5.5.1/css/foundation.min.css',
			'//cdn.jsdelivr.net/foundation/5.5.1/js/vendor/modernizr.js',
			'//cdn.jsdelivr.net/foundation/5.5.1/js/foundation.min.js',
			'app.js',
		],
	],
];
