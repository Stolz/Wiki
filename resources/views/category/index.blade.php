@extends('layouts.master')

@section('content')

	<h3 class="text-center">{{ $subtitle }}</h3>

	<ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-3">
		@foreach($trees as $tree)
		<li><div class="panel">{!! $tree !!}</div></li>
		@endforeach
	</ul>

	<p class="text-center">
		{!! link_to_route("$route.create", _('Create'), [], ['class' => 'success button']) !!}
	</p>

@stop
