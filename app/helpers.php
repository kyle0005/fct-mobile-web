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
        return rtrim($domain, '/') . $path . ($hasEnd?'?_rd=201801111520': '');
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

        $title = $share['title'];
        $link = $share['link'];
        $img = $share['img'];
        $desc = $share['desc'];
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