<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest as CreateRequest;
use App\Http\Requests\CreateCategoryRequest as UpdateRequest;
use App\Category as Model;
use App\Page;

class CategoryController extends ResourceController
{
	/**
	 * Class constructor.
	 *
	 * @param  Model
	 * @return void
	 */
	public function __construct(Model $resource)
	{
		parent::__construct($resource);
	}

	/**
	 * Display a tree of all categories.
	 *
	 * @param  Paginator
	 * @return Response
	 */
	public function index($resources = null)
	{
		// HTML of a tree node
		$template = view($this->directory . '.node')->withRoute($this->route)->render();

		// Function to render a tree node
		$render = function (array $node) use ($template) {
			$template = str_replace('_id_', $node['id'], $template);

			return str_replace('_name_', $node['name'], $template);
		};

		// Get categories hierarchy
		$hierarchy = $this->resource->all()->toHierarchy()->toArray();

		// Split hierarchy into chunks of root nodes
		$chunks = array_chunk($hierarchy, 1);

		// Add one tree per chunk
		$trees = [];
		foreach($chunks as $chunk)
			$trees[] = tree($chunk, $render);

		// Load view
		return view($this->directory . '.index', [
			'title' => _('Categories'),
			'subtitle' => _('Index'),
			'trees' => $trees,
		]);
	}

	/**
	 * Display the subtree of a category.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// Make sure resource exists
		$this->resource = $this->resource->findOrFail($id);
		$this->subtitle = $this->resource;

		// Get subcategories
		$subcategories = $this->resource->getDescendants();

		// Get pages this category
		$pages = $this->resource->pages()->orderBy('name')->get();

		// Get pages of subcategories
		$subpages = Page::whereIn('category_id', $subcategories->lists('id'))->orderBy('name')->get();

		// Function to render a tree node
		$render = function (array $node) {
			return link_to_route('category.show', $node['name'], [$node['id']]);
		};

		// Build subcategories tree
		$tree = tree($subcategories->toHierarchy()->toArray(), $render);

		view()->share(compact('pages', 'subpages', 'subcategories', 'tree'));

		return parent::show($id);
	}

	/**
	 * Create a new resource.
	 *
	 * @param  CreateRequest
	 * @return Response
	 */
	public function store(CreateRequest $request)
	{
		// The 'parent_id' attribute is guarded so it will be ignored and
		// the node will be saved as a root node
		$response = parent::_store($request);

		// If 'parent_id' was provided attach the newly created node to the provided parent
		if($parentId = intval($request->input('parent_id')))
			$this->resource->makeChildOf(Model::findOrFail($parentId));

		return $response;
	}

	/**
	 * Update an exsiting resource.
	 *
	 * @param  UpdateRequest
	 * @param  int $id
	 * @return Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		// The 'parent_id' attribute is guarded so it will be ignored and
		// the node hierarchy will not be altered.
		$response = parent::_update($request, $id);

		// If no 'parent_id' was provided it means the resource is a root node
		if($parentId = intval($request->input('parent_id')))
			$this->resource->makeChildOf(Model::findOrFail($parentId));
		else
			$this->resource->makeRoot();

		return $response;
	}

	/**
	 * Display a form for saving a resource.
	 *
	 * @param  string $subtitle Page subtitle.
	 * @param  string $action   Form route sufix.
	 * @param  string $method   Form method.
	 * @return Response
	 */
	protected function showForm($subtitle, $action, $method = 'POST')
	{
		view()->share('categories', \App\Category::dropdown());

		return parent::showForm($subtitle, $action, $method);
	}

	/**
	 * Remove the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Make sure resource exists
		$resource = $this->resource->findOrFail($id);

		// Move pages to the parent
		if(with($pages = $resource->pages)->count())
		{
			// Check if there is actually a parent category to be used as destination
			if($resource->isRoot())
			{
				Session::flash('error', _('The category cannot be deleted because it has directly assigned pages'). '. '. _('Please move those pages to another category first'));

				return redirect()->back()->withInput();
			}

			Page::where('category_id', $resource->id)->update(['category_id' => $resource->parent->id]);
		}

		// Move subcategories to the parent
		foreach($resource->children as $children)
			($resource->isRoot()) ? $children->makeRoot() : $children->makeChildOf($resource->parent);

		return parent::destroy($id);
	}
}
