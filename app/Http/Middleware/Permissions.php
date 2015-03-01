<?php namespace App\Http\Middleware;

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

		list($resource, $action) = explode('.', $request->route()->getName());

		if ($this->auth->user()->can($action, $resource))
			return $next($request);

		if ($request->ajax())
			return response('Unauthorized.', 401);

		\Session::flash('error', _('Your user is not authorized to access this section'));

		return redirect()->route('home');
	}
}
