<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-8-4
 * Time: 上午10:34
 */

if (!function_exists('fct_cdn'))
{
    function fct_cdn($path, $hasFullUrl = false, $hasEnd=true)
    {
        if (!$path)
            return '';

        $domain = '';
        if ($hasFullUrl) {
            $domain = env('APP_SECURE') ? 'https:' : 'http:';
        }
        $domain .= env('STATIC_URL', '');
        return rtrim($domain, '/') . $path . ($hasEnd?'?_rd=201806201133': '');
    }
}

if (!function_exists('wechat_share'))
{
    function wechat_share($share)
    {
        if ((!isset($share['title'])) || !$share) return '';
        if ((!isset($share['link'])) || !$share) return '';
        if ((!isset($share['img'])) || !$share) return '';
        if ((!isset($share['desc'])) || !$share) return '';
        if (!\App\FctCommon::hasWeChat())
            return '';

        $title = str_replace("\n", "<br />", $share['title']);
        $link = str_replace("\n", "<br />", $share['link']);
        $img = str_replace("\n", "<br />", $share['img']);
        $desc = str_replace("\n", "<br />", $share['desc']);
        return '<script src="//res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>'
            . '<script>' . \App\Main::weChatShare($title, $link, $img, $desc) . '</script>';
    }
}

if (!function_exists('fct_title'))
{
    function fct_title($title = '')
    {
        return ($title ? $title . ' - ' : '') . '方寸堂';
    }
}

if (!function_exists('is_mobile'))
{
    function is_mobile()
    {
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
/*        $is_pc = (strpos($agent, 'windows nt')) ? true : false;
        $is_mac = (strpos($agent, 'mac os')) ? true : false;*/
        $is_iphone = (strpos($agent, 'iphone')) ? true : false;
        $is_android = (strpos($agent, 'android')) ? true : false;
        $is_ipad = (strpos($agent, 'ipad')) ? true : false;

/*
        if($is_pc){
            return  false;
        }

        if($is_mac){
            return  true;
        }*/

        if($is_iphone){
            return  true;
        }

        if($is_android){
            return  true;
        }

        if($is_ipad){
            return  true;
        }
    }
}

if (!function_exists('image_base64'))
{
    function image_base64($url)
    {
        $info = getimagesize($url);
        $data = file_get_contents($url);
        return 'data:' . $info['mime'] . ';base64,' .chunk_split(base64_encode($data));
    }
}

if (!function_exists('api_chat_url'))
{
    function api_chat_url($url, $name)
    {
        $member = \App\Member::getAuth();
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

if (!function_exists('gen_qrcode'))
{
    function gen_qrcode($url = '')
    {
        return 'https://sapi.k780.com/?app=qr.get&level=L&size=6&data=' . $url;
    }
}

if (!function_exists('show_price')) {
    function show_price($price, $isPrice = true, $discount = 0) {
        if (is_login()) {
            if ($price > 0) {
                $str = ($isPrice ? '<small class="pri-mark">￥</small>' : '') . $price;
                if ($discount > 0) {
                    $str .= '&ensp;<del class="del-price">' . $discount . '</del>';
                }
                return $str;
            }
            return '暂无售价';
        }
        //登录成功后返回地址
        //ajax请求取referer
        if (request()->ajax()) {
            $returnUrl = request()->server('HTTP_REFERER');
        } else {
            //取当前页地址
            $returnUrl = url(request()->server('REQUEST_URI'), [], env('APP_SECURE'));
        }

        return '<a href=' . to_login() . '?' . env('REDIRECT_KEY') . '=' . $returnUrl . '>登录可见价格</a>';
    }
}

if (!function_exists('is_login')) {
    function is_login() {
        $member = \App\Member::getAuth();
        return $member && $member->memberId > 0;
    }
}

if (!function_exists('to_login')) {
    function to_login() {
        return url(\App\FctCommon::hasWeChat() ? 'oauth' : 'login', [], env('APP_SECURE'));
    }
}
