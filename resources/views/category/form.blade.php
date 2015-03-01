<div class="row">
	<div class="small-11 medium-6 large-5 small-centered columns">

	{!!
		Form::label('parent_id', _('Parent')),
		Form::select('parent_id', $categories, Input::get('parent_id')),

		Form::label('name', _('Name')),
		Form::text('name')
	!!}

	</div>

</div>
