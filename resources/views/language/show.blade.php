<?php $fields = [
	_('Name') => $resource->name,
	_('Native name') => $resource->native_name,
	_('Code') => $resource->code,
	_('Locale') => $resource->locale,
	_('Is default') => ($resource->is_default) ? _('Yes') : _('No'),
	_('Users') => $resource->users->count(),
]; ?>


<dl>
	@foreach ($fields as $label => $value)
		<dt>{{ $label }}</dt>
		<dd>{{ $value }}</dd>
	@endforeach
</dl>
