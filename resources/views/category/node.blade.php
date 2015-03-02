<a data-dropdown="drop_id_" class="secondary label" data-options="align:left">+</a>

<a href="{{ route("$route.show", ['_id_']) }}">_name_</a>

<div id="drop_id_" class="f-dropdown tiny content" data-dropdown-content >
	{!! link_to_route("$route.create", _('Create'), ['parent_id' => '_id_'], ['class' => 'tiny success button']) !!}
	{!! link_to_route("$route.edit", _('Edit'), ['_id_'], ['class'=>'tiny button']) !!}
</div>
