<?php

namespace App\Http\Middleware;

use Closure;

class Language
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		app('language'); // Workaround

		return $next($request);
	}
}
