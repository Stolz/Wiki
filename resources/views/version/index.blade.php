@extends('layouts.master')

@section('content')

	<h3 class="text-center">{{ $subtitle }}</h3>

	@if ($versions->count())

	<table summary="" style="margin-left: auto;margin-right: auto">

		<thead>
			<tr>
				<th class="text-center">{{ _('Compare') }}</th>
				<th class="text-center">{{ _('Title') }}</th>
				<th class="text-center">{{ _('Date') }}</th>
				<th class="text-center">{{ _('By') }}</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($versions as $v)
			<tr>
			<td class="text-center">
					<input type="radio" name="a" value="{{$v->id}}"/>
					<input type="radio" name="b" value="{{$v->id}}"/>
				</td>
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
		{!! link_to($compareUrl, _('Compare'), ['id' => 'compare', 'class' => 'button']) !!}
		{!! link_to($returnUrl, _('Return'), ['class' => 'secondary button']) !!}
	</p>

@stop


@section('js')
@parent
<script>
$(document).ready(function() {

	$('#compare').click(function(e) {
		var a = $('input[name=a]:checked').val();
		var b = $('input[name=b]:checked').val();

		if( ! parseInt(a) || ! parseInt(b))
			return e.preventDefault();

		$(this).prop('href', $(this).prop('href') + '/' + a + '-' + b);
	});

});
</script>
@stop
