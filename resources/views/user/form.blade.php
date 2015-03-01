<div class="row">
	<div class="small-11 medium-6 large-5 small-centered columns">

	{!!
		Form::label('language_id', _('Language')),
		Form::select('language_id', $languages),

		Form::label('provider_id', _('Provider')),
		Form::select('provider_id', $providers),

		Form::label('uuid', _('Remote id')),
		Form::text('uuid'),

		Form::label('name', _('Name')),
		Form::text('name'),

		Form::label('nickname', _('Nickname')),
		Form::text('nickname'),

		Form::label('email', _('E-mail')),
		Form::text('email'),

		Form::label('avatar', _('Avatar')),
		Form::text('avatar'),

		Form::label('is_admin', _('Is admin')),
		Form::radios('is_admin', [_('No'), _('Yes') ])

	!!}

	</div>

</div>
