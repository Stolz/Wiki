<?php $fields = [
	_('Remote id') => $resource->uuid,
	_('Name') => $resource->name,
	_('Nickname') => $resource->nickname,
	_('E-mail') => $resource->email,
	_('Avatar') => $resource->avatar,
	_('Login count') => $resource->login_count,
	_('Provider') => $resource->provider,
	_('Language') => $resource->language,
	_('Is admin') => ($resource->is_admin) ? _('Yes') : _('No'),
]; ?>

<dl>
	@foreach ($fields as $label => $value)
		<dt>{{ $label }}</dt>
		<dd>{{ $value }}</dd>
	@endforeach
</dl>

