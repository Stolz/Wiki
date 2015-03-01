<thead>
	<tr>
		<th class="text-center">{{ _('Name') }}</th>
		<th class="text-center">{{ _('Slug') }}</th>
		<th class="text-center">{{ _('Login count') }}</th>
		<th class="text-center actions">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($resources as $provider)
	<tr>
		<td>{{ $provider->name }}</td>
		<td>{{ $provider->slug }}</td>
		<td class="text-center">{{ $provider->login_count }}</td>
		@include('resource.actions', ['resource' => $provider])
	</tr>
	@endforeach
</tbody>
