<ul class="off-canvas-list">

	<li><label>{{ _('Sections') }}</label></li>
	<li>{!! link_to_route('login', _('Please login to see available sections')) !!}</li>
	<li>{!! link_to_route('login', _('Login'), [], ['class' => 'button expand']) !!}</li>

</ul>
