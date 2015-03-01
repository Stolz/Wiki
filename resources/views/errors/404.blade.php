@extends('layouts.error')

@section('problem-description')
<p>
	{{ _("We're really sorry but we couldn't find the page you requested on our servers") }}.
	{{ _("It looks like this was the result of either") }}:
</p>

<ul>
	<li>{{ _("a mistyped address") }}.</li>
	<li>{{ _("an out-of-date link") }}.</li>
</ul>
@stop

@section('css')
@parent
<style>
ul{
	margin-left:3em;
	margin-top:-.5em
}
</style>
@stop
