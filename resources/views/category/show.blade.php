<div class="row">

	{{-- PAGES --}}
	<div class="medium-6 columns">
		<div class=" panel">
			<h5 class="text-center">{{ _('Pages') }}</h5>

			@if ($pages->count())
				<ul class="side-nav">
					@foreach ($pages as $page)
						<li>{!! link_to_route('page.show', $page, [$page->getKey()]) !!}</li>
					@endforeach
				</ul>
			@else
				<p class="text-center">
					{{ _('This category has no pages yet') }}
				</p>
			@endif

			@if ($subpages->count())
				<hr/>
				<h5 class="text-center">{{ _('Pages on subcategories') }}</h5>
				<ul class="side-nav">
					@foreach ($subpages as $page)
						<li>{!! link_to_route('page.show', $page, [$page->getKey()]) !!}</li>
					@endforeach
				</ul>
			@endif

			<p class="text-center">
				{!! link_to_route('page.create', _('Create page'), ['category_id' => $resource->getKey()], ['class' => 'small success button']) !!}
			</p>

		</div>
	</div>

	{{-- SUBCATEGORIES --}}
	<div class="medium-6 columns">
		<div class="callout panel">
			<h5 class="text-center">{{ _('Subcategories') }}</h5>

			@if ($subcategories->count())
				{!! $tree !!}
			@else
				<p class="text-center">
					{{ _('This category has no subcategories') }}
				</p>
			@endif

			<p class="text-center">
				{!! link_to_route("$route.create", _('Create subcategory'), ['parent_id' => $resource->getKey()], ['class' => 'small success button']) !!}
			</p>

		</div>
	</div>

</div>
