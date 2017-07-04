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

        if ($request->ajax())
        {
            return json_encode([
                'code' => 404,
                'message' => '未登录，请登录后再执行操作',
                'url' => url('login'),
                'data' => [],
            ], JSON_UNESCAPED_UNICODE);
        }
        return redirect('login');
    }
}
