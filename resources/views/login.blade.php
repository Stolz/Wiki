@extends('layouts.master')

<?php $class = function ($provider) {
	switch($provider)
	{
		default:
			return $default;
		case 'facebook':
			return 'info';
		case 'twitter':
			return '';
		case 'google':
			return 'alert';
		case 'github':
			return 'secondary';
	}
};?>

@section('content')

	<p class="text-center">{{ _('Login or register with one click using one of these providers') }}:</p>

	<div class="medium-4 columns medium-centered">
		@foreach ($usableProviders as $provider)
			{!! link_to_route(
				'login.with',
				$provider,
				['provider' => $provider->slug],
				['class' => $class($provider->slug) . ' button expand']
			) !!}<br/>
		@endforeach
	</div>

@stop
