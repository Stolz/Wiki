<?php $fields = [
	_('Name') => $resource->name,
	_('Slug') => $resource->slug,
	_('Login count') => $resource->login_count,
	_('Users') => $resource->users->count(),
]; ?>

<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4">
	@foreach ($fields as $label => $value)
	<li><b>{{ $label }}:</b> {{ $value }}</li>
	@endforeach
</ul>
