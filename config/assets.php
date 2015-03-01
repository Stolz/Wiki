<?php

return [
	'autoload' => ['foundation-cdn'],
	'collections' => [

		// jQuery 2.x (CDN)
		'jquery2-cdn' => ['//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js'],

		// Zurb Foundation (CDN)
		'foundation-cdn' => [
			'//cdn.jsdelivr.net/foundation/5.5.1/js/vendor/modernizr.js',
			'jquery2-cdn',
			'//cdn.jsdelivr.net/foundation/5.5.1/js/foundation.min.js',
			'app.js',
			'//cdn.jsdelivr.net/foundation/5.5.1/css/normalize.css',
			'//cdn.jsdelivr.net/foundation/5.5.1/css/foundation.min.css',
		],

		// PHP debugbar https://github.com/barryvdh/laravel-debugbar
		'debugbar' => ['debugbar.css', 'debugbar.js'],
	],
];
