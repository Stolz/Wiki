@if ($languages->count())

	<ul class="off-canvas-list">

		<li class="text-center"><label>{{ _('Change language') }}</label></li>
		@foreach ($languages as $language)
			<li>{!! link_to_route('language.set', $language->native_name , ['code' => $language->code]) !!}</li>
		@endforeach

	</ul>

@endif

