<thead>
	<tr>
		<th class="text-center">{{ _('Name') }}</th>
		<th class="text-center">{{ _('Category') }}</th>
		<th class="text-center actions">{{ _('Actions') }}</th>
	</tr>
</thead>

<tbody>
	@foreach ($resources as $page)
	<tr>
		<td>{{ $page->name }}</td>
		<td>{{ $page->category }}</td>
		@include('resource.actions', ['resource' => $page])
	</tr>
	@endforeach
</tbody>
