<?php

namespace App\Http\Middleware;

class Permissions extends Authenticate
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, \Closure $next)
	{
		if ($this->auth->guest())
			return parent::handle($request, $next);

		// Last segment of the route name is the action, the rest is the resource
		$routeName = $request->route()->getName();
		$pivot = strrpos($routeName, '.');
		$resource = substr($routeName, 0, $pivot);
		$action = substr($routeName, $pivot + 1);

		if ($this->auth->user()->can($action, $resource))
			return $next($request);

		$error = sprintf(_("Your user is not authorized to perform action '%s' on resource '%s'"), $action, $resource);

		if ($request->ajax())
			return response($error, 401);

		\Session::flash('error', $error);

		return redirect()->route('home');
	}
}
