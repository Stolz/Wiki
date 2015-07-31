{{-- Live preview of Markdown --}}

<?php Assets::add(['wiki.css', 'marked.js']) ?>

<fieldset id="preview">
	<legend>{{ _('Preview') }}</legend>
	<h1 id="previewTitle">{!! $resource->name !!}</h1>
	<div id="previewBody">{!! $resource->markup !!}</div>
</fieldset>



@section('js')
@parent
<script>
$(document).ready(function() {

	var $title = $("#name"), $body = $("#source"), $previewTitle = $("#previewTitle"), $previewBody = $("#previewBody");

	// Live preview
	$title.keyup(function () {
		$previewTitle.text($title.val());
	});
	$body.keyup(function () {
		$previewBody.html(marked($body.val()));
	});

	// Sync scroll
	var $scrollers = $('#source, #preview');
	var syncScroll = function(e){
		var $other = $scrollers.not(this).off('scroll'), other = $other.get(0);
		var percentage = this.scrollTop / (this.scrollHeight - this.offsetHeight);
		other.scrollTop = percentage * (other.scrollHeight - other.offsetHeight);
		// Firefox workaround. Rebinding without delay isn't enough.
		setTimeout(function(){ $other.on('scroll', syncScroll ); },10);
	}
	$scrollers.on('scroll', syncScroll);

});
</script>
@stop





@section('css')
<style>
#preview{
	max-height:25em;
	overflow-y:scroll
}
</style>
@stop
