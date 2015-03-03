<ul class="off-canvas-list">

	<li><label>{{ $user }}</label></li>

	{{-- TODO My contribs --}}
	{{-- TODO My subscriptions --}}
	{{-- TODO My favourites --}}

	@if ($user->avatar)
	<li class="text-center"><img src="{{ $user->avatar }}" alt=""></li>
	@endif

	<li>{!! link_to_route('logout', _('Logout'), [], ['class' => 'alert button']) !!}</li>

</ul>
