<?php

namespace App\Http\Controllers;

use DomainException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Session;

abstract class ResourceController extends Controller
{
	// Meta =======================================================================================

	/**
	 * Instance of the resource this controller is in charge of.
	 * @var Model
	 */
	protected $resource;

	/**
	 * The route name used for links.
	 * @var string
	 */
	protected $route;

	/**
	 * The directory used for views.
	 * @var string
	 */
	protected $directory;

	/**
	 * Relationships to eager load when show the resource index.
	 * @var array
	 */
	protected $with = [];

	/**
	 * Page title.
	 * @var string
	 */
	protected $title;

	/**
	 * Page subtitle.
	 * @var string
	 */
	protected $subtitle;

	/**
	 * Class constructor.
	 *
	 * @param Model
	 * @return void
	 */
	public function __construct(Model $resource)
	{
		// Set the resource this controller is in charge of
		$this->resource = $resource;

		// Set default values if none are provided yet
		$this->setDefaults();

		// Pass metadata to the view
		view()->share([
			'route' => $this->route,
			'directory' => $this->directory,
		]);
	}

	// Setters ====================================================================================

	/**
	 * Set a default value for route and directory matching the current route name.
	 *
	 * @return self
	 */
	private function setDefaults()
	{
		if( ! $router = $this->getRouter())
			return $this;

		$routeSegments = explode('.', $router->currentRouteName());
		$routePrefix = array_shift($routeSegments);

		if(is_null($this->route))
			$this->setRoute($routePrefix);

		if(is_null($this->directory))
			$this->setDirectory($routePrefix);

		return $this;
	}

	/**
	 * Set the route name used for links.
	 *
	 * @param  string
	 * @return self
	 */
	protected function setRoute($route)
	{
		$this->route = $route;

		return $this;
	}

	/**
	 * Set the directory used for views.
	 *
	 * @param  string
	 * @return self
	 */
	protected function setDirectory($directory)
	{
		$this->directory = $directory;

		return $this;
	}

	/**
	 * Set the relationships that should be eager loaded when listing resource.
	 *
	 * @param  multiple
	 * @return self
	 */
	protected function setEagerLoadedRelationships()
	{
		$this->with = func_get_args();

		return $this;
	}

	// RESTfull ===================================================================================

	/**
	 * Display a paginated list of the resource.
	 *
	 * @param  Paginator
	 * @return Response
	 */
	public function index($resources = null)
	{
		// Get the resources if they have not been provided by the child class
		if(is_null($resources))
			$resources = $this->resource->with($this->with)->paginate();

		// Load view
		return view('resource.index', [
			'title' => ($this->title) ?: $this->resource->plural,
			'subtitle' => ($this->subtitle) ?: _('Index'),
			'resources' => $resources,
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		// Get the resource if it has not been provided by the child class
		if( ! $this->resource->getKey())
			$this->resource = $this->resource->findOrFail($id);

		// Load view
		return view('resource.show', [
			'title'     => ($this->title) ?: $this->resource->singular,
			'subtitle'  => ($this->subtitle) ?: _('Details'),
			'resource'  => $this->resource,
			'returnUrl' => $this->getReturnUrl(),
		]);
	}

	/**
	 * Display a form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return $this->showForm($subtitle = _('Create'), $action = 'store');
	}

	/**
	 * Display a form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// Get the resource if it has not been provided by the child class
		if( ! $this->resource->getKey())
			$this->resource = $this->resource->findOrFail($id);

		return $this->showForm($subtitle = _('Edit'), $action = 'update', $method = 'PUT');
	}

	/**
	 * Create a new resource.
	 *
	 * @param  Request
	 * @return Response
	 */
	protected function _store(Request $request)
	{
		// Transfer input to the resource
		$this->resource = $this->resource->fill($request->input());

		// Save to the storage
		return $this->save(__FUNCTION__);
	}

	/**
	 * Update an exsiting resource.
	 *
	 * @param  Request
	 * @param  int $id
	 * @return Response
	 */
	protected function _update(Request $request, $id)
	{
		// Get the resource if it has not been provided by the child class
		if( ! $this->resource->getKey())
			$this->resource = $this->resource->findOrFail($id);

		// Transfer input to the resource
		$this->resource = $this->resource->fill($request->input());

		// Save to the storage
		return $this->save(__FUNCTION__);
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

		// Delete from storage
		if($resource->delete())
		{
			$messageType = 'success';
			$message = sprintf(_('%s successfully deleted'), $resource);
			$response = redirect()->route($this->route . '.index');
		}
		else
		{
			$messageType = 'error';
			$message = _('Unable to delete resource');
			$response = redirect()->back();
		}

		Session::flash($messageType, $message);

		return $response;
	}

	// Extra ======================================================================================

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
		// Calculate form action route
		$route = $this->route . ".$action";

		// Load view
		return view('resource.form', [
			'title'     => ($this->title) ?: $this->resource->singular,
			'subtitle'  => $subtitle,
			'resource'  => $this->resource,
			'method'    => $method,
			'action'    => ($this->resource->getKey()) ? [$route, $this->resource->getKey()] : $route,
			'returnUrl' => $this->getReturnUrl(),
		]);
	}

	/**
	 * Save the resource in storage.
	 *
	 * @param  string
	 * @return Response
	 */
	protected function save($action)
	{
		// Set feedback message depending on action type
		switch($action)
		{
			default:
				$successMessage = _('%s successfully saved');
				$errorMessage = _('Unable to save %s');
				break;
			case 'store':
			case '_store':
				$successMessage = _('%s successfully created');
				$errorMessage = _('Unable to create %s');
				break;

			case 'update':
			case '_update':
				$successMessage = _('%s successfully updated');
				$errorMessage = _('Unable to update %s');
				break;
		}

		// Persist to storage
		try
		{
			if( ! $this->resource->save())
				throw new DomainException($errorMessage);

			Session::flash('success', sprintf($successMessage, $this->resource));

			return redirect()->route($this->route  . '.show', [$this->resource->getKey()]);
		}
		catch(DomainException $e)
		{
			Session::flash('error', sprintf($e->getMessage(), $this->resource));

			return redirect()->back()->withInput();
		}
	}

	/**
	 * Get the 'return to index' URL.
	 *
	 * @return string
	 */
	protected function getReturnUrl()
	{
		// If the referer page is paginated return to last visited page
		// Other wise return to index
		return (false !== strpos(\URL::previous(), '?page=')) ? \URL::previous() : route($this->route . '.index');
	}
}
