<?php

namespace App\Http\Controllers\Mobile;

use App\FctCommon;
use App\Http\Controllers\Controller;
use App\Member;
use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class BaseController extends Controller
{

    public function __construct(Request $request)
    {

        //店铺分享
        $this->setShopId();
        //设置邀请
        $this->setInviterId();

        $member = $this->memberLogged(false);
        //默认头像
        $shareAvatar = fct_cdn('/img/mobile/nologin-head.png');
        if ($member) {

            $shareAvatar = $member->headPortrait;
            view()->share('member', $member);
        }
        view()->share('shareAvatar', $shareAvatar);
    }

    /**第一次访问
     * @return bool
     */
    protected function isFirstVisit()
    {
        $key = '_f_visit';
        $bool = Cookie::has($key)
            ? Cookie::get($key) : 0;
        if ($bool) {
            Cookie::queue($key, 1, 43200);
            return true;
        }

        return false;
    }
    protected function setFirstVisit()
    {
        $key = '_f_visit';
        Cookie::queue($key, 1, 43200);
    }

    /**我的分享
     * @param $url
     * @return string
     */
    protected function myShareUrl($url)
    {
        $member = $this->memberLogged(false);
        //用户存在
        if ($member && $member->memberId) {
            $quote = strpos($url, '?') > 0 ? '&' : '?';
            $url .= sprintf('%s%s=%d', $quote, env('SHARE_MEMBER_ID_KEY'), $member->memberId);
            //申请并通过了店铺审查
            if ($member->shopId > 0) {
                $url .= sprintf('&%s=%d', env('SHARE_SHOP_ID_KEY'), $member->shopId);
            }
        }

        return $url;
    }

    /**设置分享ID
     *
     */
    protected function setInviterId()
    {
        $memberId= intval(request()->get(env('SHARE_MEMBER_ID_KEY'), 0));
        //设置微店长分享的ID
        if ($memberId > 0)
        {
            Cookie::queue(env('SHARE_MEMBER_ID_KEY'), $memberId, 43200);
        }
    }

    /**获取分享ID
     * @return int|string
     */
    protected function getInviterId()
    {
        return Cookie::has(env('SHARE_MEMBER_ID_KEY'))
            ? Cookie::get(env('SHARE_MEMBER_ID_KEY')) : 0;
    }

    /**设置店铺id
     *
     */
    protected function setShopId()
    {
        $shopId= intval(request()->get(env('SHARE_SHOP_ID_KEY'), 0));
        //设置微店长分享的ID
        if ($shopId > 0)
        {
            Cookie::queue(env('SHARE_SHOP_ID_KEY'), $shopId, 43200);
        }
    }

    /**获取店铺id
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
    protected function autoReturn($message, $code = 404, $url = null, $extras = null)
    {
        if ($code == 401) {

            $message = '登录授权已过期，请重新登录';
            Member::cleanAuth();
            $returnURL = request()->getUri();
            if (request()->method() == 'POST') {
                $returnURL = request()->server('HTTP_REFERER');
            }
            $url = sprintf('%s?%s=%s', $url, env('REDIRECT_KEY'), $returnURL);
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
            $errorUrl = url('error', [], env('APP_SECURE')) . '?message=' . $message;
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
            'categories' => ProductCategory::getCategories(),
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
            return $this->autoReturn('请先登录后再执行操作', 401, $this->getRedirectSourceUrl());
        }

        return $member;
    }

    /**是否新访客提示
     * @return bool
     */
    protected function hasNewVisitor()
    {
        $cookieName = '_new_visitor';
        $status = 0;
        $member = $this->memberLogged(false);
        if (!($member && $member->memberId > 0)){
            //是否已经访问过
            $bool = Cookie::has($cookieName) ? Cookie::get($cookieName) : 0;
            if (!$bool) $status = 1;
            Cookie::queue($cookieName, true, 10080);
        }
        return $status;
    }

    /** 聊天接口
     * @param $url
     * @param $name
     * @return string
     */
    protected function getChatUrl($url, $name)
    {
        $member = $this->memberLogged(false);
        $chatDatas = [];
        if ($member && $member->memberId > 0) {
            $chatDatas = [
                "name" => $member->userName,
                "tel" => $member->cellPhone,
            ];
        }

        $chatDatas['comment'] =  $name . '--' . $url;

        return 'https://static.meiqia.com/dist/standalone.html?_=t&eid=92491&clientid='
            . (($member && $member->memberId > 0) ? $member->memberId : "")
            . '&metadata=' .urlencode(json_encode($chatDatas, JSON_UNESCAPED_UNICODE));

    }
}
