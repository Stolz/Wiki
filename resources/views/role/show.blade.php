<?php $fields = [
	_('Name') => $resource->name,
	_('Is default') => ($resource->is_default) ? _('Yes') : _('No'),
]; ?>

<dl>
	@foreach ($fields as $label => $value)
		<dt>{{ $label }}</dt>
		<dd>{{ $value }}</dd>
	@endforeach
</dl>

