@extends('layouts.master')

@section('content')

	<h3 class="text-center">{{ $subtitle }}</h3>

	@if ($versions->count())
		TODO list versions

		{!! pagination_links($versions) !!}
	@else
		<div class="alert-box alert" data-alert>
		{{ _('No results found') }}
		<a class="close">&times;</a>
		</div>
	@endif

	<p class="text-center">
		{!! link_to($returnUrl, _('Return'), ['class' => 'secondary button']) !!}
	</p>

@stop
