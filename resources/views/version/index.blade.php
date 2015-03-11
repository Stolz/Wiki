@extends('layouts.master')

@section('content')

	<h3 class="text-center">{{ $subtitle }}</h3>

	@if ($versions->count())

	<table summary="" style="margin-left: auto;margin-right: auto">

		<thead>
			<tr>
				<th class="text-center">{{ _('Title') }}</th>
				<th class="text-center">{{ _('Date') }}</th>
				<th class="text-center">{{ _('By') }}</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($versions as $v)
			<tr>
				<td>{!! link_to_route('page.version.show', $v->name, [$v->page_id, $v->id]) !!}</td>
				<td>
					{{ $v->created_at->toDayDateTimeString() }}<br/>
					{{ $v->created_at->diffForHumans() }}
				</td>
				<td>{{ $v->user }}</td>
			</tr>
			@endforeach
		</tbody>

	</table>

		{!! pagination_links($versions) !!}
	@else
		<div class="alert-box alert" data-alert>
		{{ _('No results found') }}
		<a class="close">&times;</a>
		</div>
	@endif

	<p class="text-center">
		{!! link_to($returnUrl, _('Return'), ['class' => 'secondary button']) !!}
	</p>

@stop
