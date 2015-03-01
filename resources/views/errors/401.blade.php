@extends('layouts.error')

@section('problem-description')
<p>
	{{ _("Your user is not authorized to access this section") }}.
	{{ _("If you think this may be an error please contact the site admin") }}.
</p>

<a href="{{ URL::previous() }}" class="button expand">{{ _('Go back') }}</a>
@stop
