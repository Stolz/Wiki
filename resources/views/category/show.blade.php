<div class="row">

	{{-- PAGES --}}
	<div class="medium-7 columns">

		<h5 class="text-center">{{ _('Pages') }}</h5>

		@if ($pages->count())
			<ul>
				@foreach ($pages as $page)
					<li>{!! link_to_route('page.show', $page, [$page->getKey()]) !!}</li>
				@endforeach
			</ul>
		@else
			<p class="text-center">
				{{ _('This category has no pages yet') }}
			</p>
		@endif

		<p class="text-center">
			{!! link_to_route('page.create', _('Create page'), ['category_id' => $resource->getKey()], ['class' => 'small success button']) !!}
		</p>

	</div>

	{{-- SUBCATEGORIES --}}
	<div class="medium-5 columns">

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
