<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-8-4
 * Time: 上午10:34
 */

if (!function_exists('fct_cdn'))
{
    function fct_cdn($path, $customDomain = '')
    {
        if (!$path)
            return '';

        $domain = $customDomain ? $customDomain : env('STATIC_URL', '');
        return rtrim($domain, '/') . $path;
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