<?php $fields = [
	_('Name') => $resource->name,
	_('Native name') => $resource->native_name,
	_('Code') => $resource->code,
	_('Locale') => $resource->locale,
	_('Is default') => ($resource->is_default) ? _('Yes') : _('No'),
	_('Users') => $resource->users->count(),
]; ?>

<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4">
	@foreach ($fields as $label => $value)
	<li><b>{{ $label }}:</b> {{ $value }}</li>
	@endforeach
</ul>
