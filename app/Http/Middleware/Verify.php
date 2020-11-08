<?php

namespace App\Http\Middleware;

use Closure;

class Verify
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
		if(empty($request->get('ref')))
		{
			return redirect('/');
		}
		
        return $next($request);
    }
}
