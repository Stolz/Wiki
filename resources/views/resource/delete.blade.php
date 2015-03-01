{{-- Modal form to confirm deletion of resource --}}

{!! Form::open([
	'method' => 'DELETE',
	'route' => ["$route.destroy", $resource->getKey()],
	'id' => 'delete-modal-form-' . $resource->getKey(),
	'class' => 'reveal-modal small',
	'data-reveal'
]) !!}

	<h3 class="prompt text-center">{{ sprintf(_("Delete '%s'"), $resource) }} </h3>

	<p class="lead text-center">{{ _('Are you sure?') }}</p>

	<div class="row">
		<div class="small-6 columns">
			<a class="close-modal-button secondary button expand">{{ _('Cancel') }}</a>
		</div>

		<div class="small-6 columns">
			{!! Form::submit(_('Confirm'), ['class' => 'alert button expand']) !!}
		</div>
	</div>
	<a class="close-reveal-modal">&#215;</a>
{!! Form::close() !!}


@section('js')
@parent
<script>
$(document).ready(function() {

	// Clicking on 'cancel' button closes modal
	$('form .close-modal-button').click(function() {
		$(this).foundation('reveal', 'close');
	});

});
</script>
@stop
