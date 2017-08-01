<?php

namespace App\Http\Middleware;

use App\FctCommon;
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

        Member::cleanAuth();
        if ($request->ajax())
        {
            return json_encode([
                'code' => 404,
                'message' => '登录授权已过期，请重新登录',
                'url' => url('login'),
                'data' => [],
            ], JSON_UNESCAPED_UNICODE);
        }

        FctCommon::cacheRedirectURI($request->url(), true);

        return redirect(FctCommon::hasWeChat() ? 'oauth' : 'login');
    }
}
