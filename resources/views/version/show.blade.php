@extends('layouts.master')

@section('content')

	<p class="text-center">
		<i>{{ sprintf(_('Version created by %s on %s (%s)'), $version->user, $version->created_at->toDayDateTimeString(), $version->created_at->diffForHumans()) }}</i>
	</p>

	<h3 class="text-center">{{ $subtitle }}</h3>

	{!! markup($version->source) !!}

	<p class="text-center">
		{!! link_to_route('page.version.index', _('Return'), [$version->page_id], ['class' => 'secondary button']) !!}
	</p>

@stop
