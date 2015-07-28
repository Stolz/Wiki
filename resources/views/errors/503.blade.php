@extends('layouts.error')

<?php app('language')->apply() ?>

@section('body')
<div id="maintenance" class="row">
	<div class="large-8 columns large-centered text-center">
		<ul class="pricing-table">
			<li class="title">{{ config('app.name') }}</li>
			<li class="price">{{ _('Site down for maintenance') }}</li>
			<li class="description">{{ _('Sorry, our site is currently undergoing scheduled maintenance') }}.</li>
			<li class="cta-button"><a class="button" href="{!! URL::current() !!}">{{ _('Please visit us again in a few minutes') }}</a></li>
		</ul>
	</div>
</div>
@stop

@section('css')
<style>
#maintenance {margin-top:4em}
#maintenance .title {font-size:200%}
#maintenance .price {font-size:150%}
#maintenance .description {font-size:125%}
</style>
@stop
