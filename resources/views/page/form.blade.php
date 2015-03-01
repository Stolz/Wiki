<div class="row">

	<div class="small-11 medium-6 large-5 small-centered columns">

	{!!
		Form::label('category_id', _('Category')),
		Form::select('category_id', $categories, Input::get('category_id')),

		Form::label('name', _('Name')),
		Form::text('name'),

		Form::label('source', _('Content')),
		Form::textarea('source')
	!!}

	</div>

</div>
