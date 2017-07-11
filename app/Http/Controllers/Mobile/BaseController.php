<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Member;
use Illuminate\Support\Facades\Cookie;

class BaseController extends Controller
{
    protected function cacheRedirectSourceUrl($url = '', $hasCacheCookie = false)
    {
        $url = $url ? $url : $this->getRedirectSourceUrl();
        if ($hasCacheCookie)
        {
            Cookie::queue(env('REDIRECT_KEY'), $url, 10);
        }
        else
        {
            request()->merge([env('REDIRECT_KEY') => $url]);
        }
    }
    /**获取用户自定义返回原地址
     * @return \Illuminate\Contracts\Routing\UrlGenerator|mixed|string
     */
    protected function getRedirectSourceUrl()
    {
        //主动传递跳转url
        $redirectUrl = request()->get(env('REDIRECT_KEY'));
        if ($redirectUrl)
        {
            return $redirectUrl;
        }

        //系统与第三方系统交互，临时存入cookie中
        if (Cookie::has(env('REDIRECT_KEY')) && Cookie::get(env('REDIRECT_KEY')))
        {
            $redirectUrl = Cookie::get(env('REDIRECT_KEY'));
            Cookie::forget(env('REDIRECT_KEY'));
            return $redirectUrl;
        }

        //返回默认指定页面
        return url('/');
    }

    /**成功ajax返回内容
     * @param $message
     * @param null $url
     * @param null $extras
     * @return string
     */
    protected function returnAjaxSuccess($message, $url = null, $extras = null)
    {
        return json_encode([
            'code' => 200,
            'message' => $message,
            'url' => $url,
            'data' => $extras,
        ], JSON_UNESCAPED_UNICODE);
    }

    /**失败ajax返回内容
     * @param $message
     * @param null $url
     * @param null $extras
     * @return string
     */
    protected function returnAjaxError($message, $url = null, $extras = null)
    {
        return json_encode([
            'code' => 404,
            'message' => $message,
            'url' => $url,
            'data' => $extras,
        ], JSON_UNESCAPED_UNICODE);
    }

    /**自动判断是AJAX还是post
     * @param $message
     * @param null $url
     * @param null $extras
     * @return string
     */
    protected function autoReturn($message, $url = null, $code = 404, $extras = null)
    {
        if (request()->ajax()) {
            return json_encode([
                'code' => $code,
                'message' => $message,
                'url' => $url,
                'data' => $extras,
            ], JSON_UNESCAPED_UNICODE);
        }

        if ($code != 200)
        {
            $errorUrl = url('error') . '?message=' . $message;
            if ($url)
                $errorUrl .= '&' . env('REDIRECT_KEY') . '=' . $url;

            return redirect($errorUrl, 301);
        }

        return redirect($url ? $url : '', 301);
    }

    protected function errorPage($message, $url = '')
    {
        return $message;
        //return view('error');
    }

    /**用户没登录跳转到登录页面
     * @return string
     */
    protected function memberLogged($hasReturnError = true)
    {
        $member = Member::getAuth();
        if ($hasReturnError && !$member)
        {
            return $this->autoReturn('请先登录后再执行操作', $this->getRedirectSourceUrl(), 404);
        }

        return $member;
    }

}
