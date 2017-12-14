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
        //缓存当前地址
        $returnURL = $request->getUri();
        if ($request->method() == 'POST') {
            $returnURL = request()->server('HTTP_REFERER');
        }
        FctCommon::cacheRedirectURI($returnURL, true);

        if ($request->ajax())
        {
            return new Response([
                'code' => 404,
                'message' => '登录授权已过期，请重新登录',
                'url' => url(FctCommon::hasWeChat() ? 'oauth' : 'login', [], env('APP_SECURE')),
                'data' => [],
            ]);
        }

        return redirect(url(FctCommon::hasWeChat() ? 'oauth' : 'login', [], env('APP_SECURE')));
    }
}
