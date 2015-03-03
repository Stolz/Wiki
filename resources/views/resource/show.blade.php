@extends('layouts.master')

<?php

$buttons = [

	link_to($returnUrl, _('Return'), ['class' => 'secondary button']),

	link_to_route(
		"$route.edit",
		_('Edit'),
		[$resource->getKey()],
		['class' => 'button']
	),

	link_to_route(
		"$route.destroy",
		_('Delete'),
		[$resource->getKey()],
		['class' => 'alert button', 'data-reveal-id' => 'delete-modal-form-' . $resource->getKey()]
	),
];
?>

@section('content')

	<h3 class="text-center">{{ $subtitle }}</h3>

	@include("$directory.show", ['resource'=> $resource])
	@include('resource.delete', ['resource' => $resource])

	<p class="text-center">
		@foreach ($buttons as $button)
		{!! $button !!}
		@endforeach
	</p>

@stop
