<div class="row">

	<div class="small-11 medium-6 large-5 small-centered columns">

	{!!
		Form::label('code', _('Code')),
		Form::text('code'),

		Form::label('name', _('Name')),
		Form::text('name'),

		Form::label('native_name', _('Native name')),
		Form::text('native_name'),

		Form::label('locale', _('Locale')),
		Form::text('locale'),

		Form::label('is_default', _('Is default')),
		Form::radios('is_default', [_('No'), _('Yes') ])
	!!}

	</div>

</div>



