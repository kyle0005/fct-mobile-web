<?php

namespace App\Http\Controllers\Mobile;

use App\FctCommon;
use App\Http\Controllers\Controller;
use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class BaseController extends Controller
{

    public function __construct(Request $request)
    {
        $member = $this->memberLogged(false);
        if ($member) {
            view()->share('member', $member);
        }
    }

    /**设置分享id
     *
     */
    protected function setShopId()
    {
        $shopId= intval(request()->get(env('SHARE_SHOP_ID_KEY'), 0));
        //设置微店长分享的ID
        if ($shopId > 0 && $shopId <> $this->getShopId())
        {
            Cookie::queue(env('SHARE_SHOP_ID_KEY'), $shopId, 10080);
        }
    }

    /**获取分享id
     * @return string
     */
    protected function getShopId()
    {
        return Cookie::has(env('SHARE_SHOP_ID_KEY'))
            ? Cookie::get(env('SHARE_SHOP_ID_KEY')) : 0;
    }

    /**缓存用户跳转地址
     * @param string $url
     * @param bool $hasCacheCookie
     */
    protected function cacheRedirectSourceUrl($url = '', $hasCacheCookie = false)
    {
        return FctCommon::cacheRedirectURI($url, $hasCacheCookie);
    }
    /**获取用户自定义返回原地址
     * @return \Illuminate\Contracts\Routing\UrlGenerator|mixed|string
     */
    protected function getRedirectSourceUrl($hasCleanCache = true, $hasDefault = true)
    {
        return FctCommon::getRedirectURI($hasDefault);
    }

    protected function cleanRedirectSourceUrl()
    {
        Cookie::forget(env('REDIRECT_KEY'));
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
        if ($message == 'loginExpire') {

            $message = '登录授权已过期，请重新登录';
            Member::cleanAuth();
        }
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

            return redirect($errorUrl);
        }

        return redirect($url ? $url : '');
    }

    protected function errorPage($message, $url = '')
    {

        return view('errors.404', [
            'title' => 'Error',
            'message' => $message,
            'url' => $url,
        ]);
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
