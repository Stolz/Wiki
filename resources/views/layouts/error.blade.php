@extends('layouts.base')

@section('body')
<div class="row">
	<div class="large-7 columns large-centered">

		<h2 class="text-center">{{ config('site.name') }}</h2>

		<div class="panel radius">
			<div class="row collapse">
				<div class="small-10 columns">
					<h5>{{ _('Error') }} <span class="color">{{ $code }}</span></h5>
					<h4>{{ $title }}</h4>
				</div>
				<div id="sad" class="small-2 columns text-center"><h1 class="color">:(</h1></div>
			</div>

			<hr/>

			@section('problem-description')
			<p>
			{{ _("Something went wrong while we were processing your request") }}.
			{{ _("We're really sorry about this, and will work hard to get this resolved as soon as possible") }}.
			</p>
			@show

			<p>{!! sprintf(_('Perhaps you would like to go to our %shome page%s?'), '<a href="/">', '</a>') !!}</p>
			<script>
			var GOOG_FIXURL_LANG = (navigator.language || '').slice(0,2),GOOG_FIXURL_SITE = location.host;
			</script>
			<script src="http://linkhelp.clients.google.com/tbproxy/lh/wm/fixurl.js"></script>

		</div><!--.panel-->
	</div>
</div>
@stop

@section('css')
<style>
body {background: #fcfcfc;}
hr{margin-top:0}
.panel{
	box-shadow: 0 1px 10px #a7a7a7, inset 0 1px 0 #fff;
}
.color{
	color:#2ba6cb !important
}
#sad{
	transform: rotate(90deg);
	-webkit-transform: rotate(90deg);
	-moz-transform: rotate(90deg);
	text-shadow: 0px 0px 5px #666;
}

/* google search */

.other-things{font-size: 100%}

#goog-fixurl ul {
	list-style: none;
	padding: 0;
	margin: 0;
}
#goog-fixurl form {
	margin: 0;
}
#goog-wm-qt,
#goog-wm-sb {
	border: 1px solid #bbb;
	font-size: 16px;
	line-height: normal;
	vertical-align: top;
	color: #444;
	border-radius: 2px;
}
#goog-wm-qt {
	box-shadow: inset 0 1px 1px #ccc;
}
#goog-wm-sb {
	display: inline-block;
	height: 32px;
	padding: 0 10px;
	margin: 5px 0 0;
	white-space: nowrap;
	cursor: pointer;
	background-color: #f5f5f5;
	background-image: -webkit-linear-gradient(rgba(255,255,255,0), #f1f1f1);
	background-image: -moz-linear-gradient(rgba(255,255,255,0), #f1f1f1);
	background-image: -ms-linear-gradient(rgba(255,255,255,0), #f1f1f1);
	background-image: -o-linear-gradient(rgba(255,255,255,0), #f1f1f1);
	-webkit-appearance: none;
	-moz-appearance: none;
	appearance: none;
	*overflow: visible;
	*display: inline;
	*zoom: 1;
}
#goog-wm-sb:hover,
#goog-wm-sb:focus {
	border-color: #aaa;
	box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
	background-color: #f8f8f8;
}
#goog-wm-qt:hover,
#goog-wm-qt:focus {
	border-color: #105cb6;
	outline: 0;
	color: #222;
}
input::-moz-focus-inner {
	padding: 0;
	border: 0;
}
</style>
@stop
