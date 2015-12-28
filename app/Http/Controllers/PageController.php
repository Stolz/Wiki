<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePageRequest as CreateRequest;
use App\Http\Requests\CreatePageRequest as UpdateRequest;
use App\Page as Model;

class PageController extends ResourceController
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
		$this->setEagerLoadedRelationships('category');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// Make sure resource exists
		$this->resource = $this->resource->findOrFail($id);
		$this->subtitle = $this->resource;

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
		return parent::_store($request);
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
		return parent::_update($request, $id);
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
	 * Get the 'return to index' URL.
	 *
	 * @return string
	 */
	protected function getReturnUrl()
	{
		if($this->resource->category and $this->resource->category->getKey())
			return route('category.show', [$this->resource->category->getKey()]);

		return parent::getReturnUrl();
	}
}
