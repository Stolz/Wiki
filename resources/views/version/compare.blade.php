@extends('layouts.master')

<?php Assets::add('diff.css') ?>

@section('content')

	<h3 class="text-center">{{ $subtitle }}</h3>


		{{-- FACTS --}}
		<div class="row">
			<div class="small-6 columns">
				<ul class="pricing-table">
					<li class="title">{{ _('Before') }}</li>
					<li class="price">{{ $before->name }}</li>
					<li class="description">{{ _('Created by') }}: {{ $before->user }}</li>
					<li class="bullet-item">{{ $before->created_at }} {{ $before->created_at->diffForHumans() }}</li>
					<li class="cta-button"><a class="button" href="TODO">{{ _('Restore') }}</a></li>
				</ul>
			</div>

			<div class="small-6 columns">
				<ul class="pricing-table">
					<li class="title">{{ _('After') }}</li>
					<li class="price">{{ $after->name }}</li>
					<li class="description">{{ _('Created by') }}: {{ $after->user }}</li>
					<li class="bullet-item">{{ $after->created_at }} {{ $after->created_at->diffForHumans() }}</li>
					<li class="cta-button"><a class="button" href="TODO">{{ _('Restore') }}</a></li>
				</ul>
			</div>
		</div>

		{{-- TAB BUTTONS --}}
		<ul class="tabs button-group even-2" data-tab>
			<li class="active"><a href="#panel1" class="secondary button">{{ _('Side by side') }}</a></li>
			<li><a href="#panel2" class="secondary button">{{ _('Inline') }}</a></li>
		</ul>

		{{-- TABS --}}
		<div class="tabs-content">
			<div class="content active" id="panel1">
				{!! $sideBySideDiff !!}
			</div>

			<div class="content" id="panel2">
				{!! $inlineDiff !!}
			</div>

		</div>

	<p class="text-center">
		{!! link_to_route('page.version.index', _('Return'), [$before->page_id], ['class' => 'secondary button']) !!}
	</p>

@stop
