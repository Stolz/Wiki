<div class="row">
	<div class="small-6 medium-5 columns">
	{!!
		Form::label('category_id', _('Category')),
		Form::select('category_id', $categories, Input::get('category_id'))
	!!}
	</div>

	<div class="small-6 medium-7 columns">
	{!!
		Form::label('name', _('Name')),
		Form::text('name')
	!!}
	</div>
</div>

{!!
	Form::label('source', _('Content')),
	Form::textarea('source')
!!}

@include("$directory.preview")
