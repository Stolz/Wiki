<thead>
	<tr>
		<th class="text-center">{{ _('Name') }}</th>
		<th class="text-center">{{ _('Is default') }}</th>
		<th class="text-center actions">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($resources as $language)
	<tr>
		<td>{{ $language->name }}</td>
		<td class="text-center">{{ ($language->is_default) ? _('Yes') : _('No') }}</td>
		@include('resource.actions', ['resource' => $language])
	</tr>
	@endforeach
</tbody>
