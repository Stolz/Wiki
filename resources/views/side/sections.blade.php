<ul class="off-canvas-list">

	<li><label>{{ _('Sections') }}</label></li>

	@foreach ($sections as $route => $title)
		<li>{!! link_to_route($route, $title) !!}</li>
	@endforeach

	<li>{!! link_to_route('logout', _('Logout'), [], ['class' => 'alert button']) !!}</li>

</ul>
