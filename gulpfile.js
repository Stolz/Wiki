// Bower components path
var bower = 'resources/assets/bower/';

// Zurb Foundation vendor dependencies
var vendor = ['vendor/modernizr.js', 'vendor/jquery.js'];

// Zurb Foundation components
var components = [
	'foundation/foundation.js',
	//'foundation/foundation.abide.js',
	//'foundation/foundation.accordion.js',
	'foundation/foundation.alert.js',
	//'foundation/foundation.clearing.js',
	'foundation/foundation.dropdown.js',
	//'foundation/foundation.equalizer.js',
	//'foundation/foundation.interchange.js',
	//'foundation/foundation.joyride.js',
	//'foundation/foundation.magellan.js',
	'foundation/foundation.offcanvas.js',
	//'foundation/foundation.orbit.js',
	'foundation/foundation.reveal.js',
	//'foundation/foundation.slider.js',
	'foundation/foundation.tab.js',
	//'foundation/foundation.tooltip.js',
	//'foundation/foundation.topbar.js'
];

var elixir = require('laravel-elixir');
elixir.config.sourcemaps = false;
elixir(function(mix) {

	// Compile CSS
	mix.sass('app.scss', 'public/css/foundation.css', {includePaths: [bower + 'foundation/scss']});

	// Compile JavaScript
	mix.scripts(vendor.concat(components), 'public/js/foundation.js', bower + 'foundation/js');

});
