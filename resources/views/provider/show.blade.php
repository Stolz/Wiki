<?php $fields = [
	_('Name') => $resource->name,
	_('Slug') => $resource->slug,
	_('Login count') => $resource->login_count,
	_('Users') => $resource->users->count(),
]; ?>

<dl>
	@foreach ($fields as $label => $value)
		<dt>{{ $label }}</dt>
		<dd>{{ $value }}</dd>
	@endforeach
</dl>

