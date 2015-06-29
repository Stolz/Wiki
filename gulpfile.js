var foundation = {
	// Base path for Bower components
	path: 'resources/assets/bower/foundation/',

	// Vendor dependencies
	vendor: ['vendor/modernizr.js', 'vendor/jquery.js', 'vendor/fastclick.js'],

	// Components
	components: [
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
	]
}

var elixir = require('laravel-elixir');
elixir.config.sourcemaps = false;
elixir(function(mix) {

	// Compile CSS
	mix.sass('app.scss', 'public/css/foundation.css', {includePaths: [foundation.path + 'scss']});

	// Compile JavaScript
	mix.scripts(foundation.vendor.concat(foundation.components), 'public/js/foundation.js', foundation.path + 'js');
	mix.copy('node_modules/marked/marked.min.js', 'public/js/marked.js');


});
