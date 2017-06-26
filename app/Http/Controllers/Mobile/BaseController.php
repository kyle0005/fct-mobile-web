<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;

class BaseController extends Controller
{

    /**获取用户自定义返回原地址
     * @return \Illuminate\Contracts\Routing\UrlGenerator|mixed|string
     */
    protected function getRedirectSourceUrl()
    {

        $redirectKey = 'redirect-url';
        //主动传递跳转url
        if (request()->has($redirectKey) && request()->get($redirectKey))
        {
            return request()->get($redirectKey);
        }

        //系统与第三方系统交互，临时存入cookie中
        if (Cookie::has($redirectKey) && Cookie::get($redirectKey))
        {
            return Cookie::get($redirectKey);
        }

        //返回默认指定页面
        return route('home');
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
            'extras' => $extras,
        ]);
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
            'extras' => $extras,
        ]);
    }

    /**自动判断是AJAX还是post
     * @param $message
     * @param null $url
     * @param null $extras
     * @return string
     */
    protected function autoReturn($message, $url = null, $code = 404, $extras = null)
    {
        if (Request::ajax()) {
            return json_encode([
                'code' => $code,
                'message' => $message,
                'url' => $url,
                'extras' => $extras,
            ]);
        }

        return redirect($url ? $url : '', 301);
    }

}
