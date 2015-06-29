if(typeof $ != 'undefined') {

	var $doc = $(document);

	$doc.ready(function() {

		// Zurb Foundation
		if($.fn.foundation)
		{
			$doc.foundation();

			$('form').not('.nospinner').submit(function() {
				$(':input[type=submit]', $(this)).prop("disabled", true);
				$(this).append('<div class="slideshow-wrapper"><div class="preloader"></div></div>');
				return true;
			});
		}
	});
}



