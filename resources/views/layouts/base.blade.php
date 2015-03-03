<!DOCTYPE html>
<html class="no-js" lang="{{ $appLanguage->code }}">
	<head>
		{{-- Misc --}}
		<title>{{ $title }} | {{ $appName }}</title>
		<base href="/" />
		<meta charset="utf-8">
		<meta name="author" content="twitter: @Stolz" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />{{-- Force latest IE rendering engine or Chrome Frame if available --}}

		{{-- Mobile  --}}
		<meta name="viewport" content="width=device-width, initial-scale=1.0">{{-- Webkit. To disable zooming add ", maximum-scale=1.0, user-scalable=no" --}}
		<meta name="HandheldFriendly" content="True" />{{-- BlackBerry --}}
		<meta name="MobileOptimized" content="960" />{{-- Windows Mobile --}}
		<meta http-equiv="cleartype" content="on" />{{-- Windows Mobile --}}

		{{-- Favicon  --}}
		<link rel="icon" href="favicon.ico" type="image/x-icon" />

		{{-- CSS  --}}
		{!! Assets::css() !!}
		@yield('css')
	</head>
	<body>
		@yield('body')

		{{-- JavaScript  --}}
		{!! Assets::js() !!}
		@yield('js')

		{{-- Debug --}}
		{!! $debug or null !!}
	</body>
</html>
