@extends('layouts.master')

@section('content')

	@if($errors->any())
	<div class="alert-box warning" data-alert>
		{{ _('Some errors occurred') }}<a class="close">&times;</a>
	</div>
	@endif


	<h3 class="text-center">{{ $subtitle }}</h3>

	{!! Form::model($resource, ['method' => $method, 'route' => $action]) !!}

		@include("$directory.form", ['resource'=> $resource])

		<p class="text-center">

			<a href="{{ $returnUrl }}" class="secondary button">{{ _('Cancel') }}</a>

			{!! Form::submit($subtitle, ['class' => 'button']) !!}

		</p>

	{!! Form::close() !!}

@stop


@section('css')
@parent
<style>
form {margin-left: auto;margin-right: auto;width:auto;}
</style>
@stop




