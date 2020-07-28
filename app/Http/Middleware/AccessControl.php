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
        // dd(getLoggedUser()['role']['name']);
        // dd(auth()->user()->role['name']);
		if (!in_array(auth()->user()->role['name'], $can_access)) {

			// whether condition is true
			// return the 404 Page
			// instead of return back()


            // return back()->with([
            //     'notif.style' => 'danger',
            //     'notif.icon' => 'times-circle',
            //     'notif.message' => 'Unauthorized Access!',
            // ]);
            return apiReturn(auth()->user(), 'Unauthorized Access!', 'failed');
			abort(404);
		}
        return $next($request);
    }
}
