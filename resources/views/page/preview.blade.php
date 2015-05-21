{{-- Live preview of Markdown --}}

<?php Assets::add(['wiki.css', 'marked.js']) ?>

<fieldset>
	<legend><label>{{ _('Preview') }}</label></legend>
	<div id="preview">{!! $resource->markup !!}</div>
</fieldset>

@section('js')
@parent
<script>
$(document).ready(function() {

	var $source = $("#source"), $preview = $("#preview");
	$source.keyup(function () {
		$preview.html(marked($(this).val()));
	});

});
</script>
@stop
