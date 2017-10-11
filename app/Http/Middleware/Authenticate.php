<?php

namespace App\Http\Middleware;

use App\FctCommon;
use App\Member;
use Closure;
use Illuminate\Http\Response;

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

        Member::cleanAuth();
        if ($request->ajax())
        {
            return new Response([
                'code' => 404,
                'message' => '登录授权已过期，请重新登录',
                'url' => url('login', [], env('APP_SECURE')),
                'data' => [],
            ]);
        }

        FctCommon::cacheRedirectURI($request->getUri(), true);

        return redirect(url(FctCommon::hasWeChat() ? 'oauth' : 'login', [], env('APP_SECURE')));
    }
}
