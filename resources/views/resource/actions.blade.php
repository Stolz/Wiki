<?php
$buttons = [
	link_to_route(
		"$route.show",
		_('Details'),
		[$resource->getKey()],
		['class' => 'small secondary button']
	),

	link_to_route(
		"$route.edit",
		_('Edit'),
		[$resource->getKey()],
		['class' => 'small button']
	),

	link_to_route(
		"$route.destroy",
		_('Delete'),
		[$resource->getKey()],
		['class' => 'small alert button', 'data-reveal-id' => 'delete-modal-form-' . $resource->getKey()]
	),
];
?>

<td class="actions">

	@foreach ($buttons as $button)
	{!! $button !!}
	@endforeach

	@include('resource.delete', ['resource' => $resource])
</td>

