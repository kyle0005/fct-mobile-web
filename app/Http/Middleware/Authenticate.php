<?php

namespace App\Http\Middleware;

use App\Member;
use Closure;

class Authenticate
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
        if (Member::getAuth())
            return $next($request);

        return redirect('login');
    }
}
