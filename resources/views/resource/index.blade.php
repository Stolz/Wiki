@extends('layouts.master')

@section('content')

	<h3 class="text-center">{{ $subtitle }}</h3>

	@if ($resources->count())
		<table summary="">
		@include("$directory.index", ['resources'=> $resources])
		</table>

		{!! pagination_links($resources) !!}
	@else
		<div class="alert-box alert" data-alert>
		{{ _('No results found') }}
		<a class="close">&times;</a>
		</div>
	@endif

	<p class="text-center">
		{!! link_to_route("$route.create", _('Create'), [], ['class' => 'success button']) !!}
	</p>

@stop


@section('css')
@parent
<style>
table {margin-left: auto;margin-right: auto;width:auto;}
table .actions {white-space:nowrap;}
table .actions .button {margin:0;padding:.3em .5em;}
</style>
@stop
