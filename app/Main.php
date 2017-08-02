<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-6-22
 * Time: 下午3:31
 */

namespace App;


use App\Exceptions\BusinessException;

class Main
{
    public static function getHome($categoryId = 1, $levelId = 1, $pageIndex = 1)
    {
        $pageSize = 10;
        $result = Base::http(
            env('API_URL') . '/mall/home',
            [
                'category_id' => $categoryId,
                'level_id' => $levelId,
                'page_index' => $pageIndex,
                'page_size' => $pageSize,
            ],
            [],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        $result = $result->data;

        $pagination = Base::pagination($result->goodsList, $pageSize);

        $result->pagination = $pagination;
        return $result;
    }

    public static function welcome()
    {
        $slides = [
            ["image" => "/images/resource/01.png", "url" => "javascript:;"],
            ["image" => "/images/resource/02.png", "url" => "javascript:;"],
            ["image" => "/images/resource/03.png", "url" => "javascript:;"],
            //["image" => "images/resource/04.png", "url" => "javascript:;"],
        ];

        return [
            'title' => '欢迎使用方寸网',
            'slides' => json_encode($slides, JSON_UNESCAPED_UNICODE),
        ];

    }

    public static function getPcHome()
    {
        $result = Base::http(
            env('API_URL') . '/mall/pc-home',
            [
                'article_code' => "",
                'article_count' => 4,
                'product_count' => 10,
                'artist_count' => 7,
            ],
            [],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return [
            'title' => '方寸网',
            'articles' =>  $result->data ? $result->data->articleList : "",
            'products' => $result->data ? $result->data->productList : "",
            'artists' => $result->data ? $result->data->artistList : "",
        ];
    }

    public static function weChatShare($title, $link, $desc, $imgUrl, $jsApiList = [])
    {
        $result = Base::http(
            env('API_URL') . '/mall/share/wechat',
            [
                'share_url' => request()->url(),
            ],
            [],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        $weChatConfig = $result->data;
        if (!$weChatConfig)
            return '';

        $jsShares = [
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'onMenuShareQZone',
        ];
        if (!$jsApiList)
        {
            $jsApiList = $jsShares;
        }
        $weChatConfig->jsApiList = $jsApiList;

        $shareStr = '';
        foreach ($jsShares as $value)
        {
            if (in_array($value, $jsApiList))
            {
                $desc = $value == 'onMenuShareTimeline' ? null : $desc;
                $shareStr .= 'wx.'.$value.'('
                    .self::getWeChatShareObject($title, $link, $desc, $imgUrl).');';
            }
        }
        $response = '';
        if ($shareStr && $result->data) {
            $response .= 'wx.config(' . json_encode($result->data, JSON_UNESCAPED_UNICODE) . ');';
            $response .= 'wx.error(function(res){alert(res);});';
            $response .= 'wx.checkJsApi({jsApiList:' . json_encode($jsApiList, JSON_UNESCAPED_UNICODE) . ', success:function(res){alert(res);}});';
            $response .= 'wx.ready(function(){'.$shareStr.'});';
        }

        return $response;
    }

    public static function getWeChatShareObject($title, $link, $desc, $imgUrl)
    {
        $result = 'title:"'.$title.'",link:"'.$link.'",imgUrl:"'.$imgUrl.'"';
        if (!is_null($desc)) {
            $result .= ',desc:"'.$desc.'"';
        }
        $result .= ',success:function(){},cancel:function(){}';

        return '{'.$result.'}';
    }
}