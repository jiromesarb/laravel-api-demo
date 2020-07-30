<?php

namespace App\Http\Middleware;

use Closure;

class AccessControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$can_access)
    {
		if (!in_array(auth()->user()->role['name'], $can_access)) {
            return apiReturn(auth()->user(), 'Unauthorized Access!', 'failed');
			abort(404);
		}
        return $next($request);
    }
}
