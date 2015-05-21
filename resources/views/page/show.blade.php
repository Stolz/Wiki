<?php Assets::add('wiki.css'); ?>

{!! $resource->markup !!}

<p class="text-center">{!! link_to_route('page.version.index', _('View page versions'), [$resource->getKey()], ['class' => 'info tiny button']) !!}</p>

