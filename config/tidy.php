<?php

/*
|--------------------------------------------------------------------------
| HTML Tidy Laravel filter
|--------------------------------------------------------------------------
|
| Here is a list of all available config options with their default values.
|
| For more info please visit https://github.com/Stolz/laravel-html-tidy
|
*/
return [

	// Enable if PHP has tidy extension support
	'enabled' => app()->environment('local'),

	// Errors that match these regexs wont be displayed
	'ignored_errors' => [
		// workaround to hide errors related to HTML5
		"/line.*proprietary attribute \"aria-.*\n?/",
		"/line.*proprietary attribute \"data-.*\n?/",
		"/line.*proprietary attribute \"placeholder.*\n?/",
		"/line.*is not approved by W3C\n?/",
		"/line.*<html> proprietary attribute \"class\"\n?/",
		"/line.*<meta> proprietary attribute \"charset\"\n?/",
		"/line.*<meta> lacks \"content\" attribute\n?/",
		"/line.*<table> lacks \"summary\" attribute\n?/",
		"/line.*<style> inserting \"type\" attribute\n?/",
		"/line.*<script> inserting \"type\" attribute\n?/",
		"/line.*<input> proprietary attribute \"autocomplete\"\n?/",
		"/line.*<input> proprietary attribute \"autofocus\"\n?/",
		// CSS frameworks use a lot of empty tags for navigation/pagination
		"/line.*trimming empty <li>\n?/",
		"/line.*trimming empty <span>\n?/",
		// Laravel pagination links dont scape ampersands
		"/line.*or unknown entity \"&sortby\"\n?/",
		"/line.*or unknown entity \"&sortdir\"\n?/",
	],

];
