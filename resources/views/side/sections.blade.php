<ul class="off-canvas-list">

	<li><label>{{ _('Sections') }}</label></li>

	@foreach ($sections as $route => $title)
		<li>{!! link_to_route("$route.index", $title) !!}</li>
	@endforeach

</ul>
