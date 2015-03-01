<thead>
	<tr>
		<th>{{ _('Provider') }}</th>
		<th>{{ _('Remote id') }}</th>
		<th>{{ _('Name') }}</th>
		<th>{{ _('Nickname') }}</th>
		<th>{{ _('E-mail') }}</th>
		<th>{{ _('Language') }}</th>
		<th class="text-center">{{ _('Login count') }}</th>
		<th class="text-center">{{ _('Is admin') }}</th>
		<th class="text-center actions">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($resources as $user)
	<tr>
		<td>{{ $user->provider }}</td>
		<td>{{ $user->uuid }}</td>
		<td>{{ $user->name }}</td>
		<td>{{ $user->nickname }}</td>
		<td>{{ $user->email }}</td>
		<td>{{ $user->language }}</td>
		<td class="text-center">{{ $user->login_count }}</td>
		<td class="text-center">{{ ($user->is_admin) ? _('Yes') : _('No') }}</td>
		@include('resource.actions', ['resource' => $user])
	</tr>
	@endforeach
</tbody>
