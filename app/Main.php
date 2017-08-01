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
            ["image" => "images/resource/01.png", "url" => "javascript:;"],
            ["image" => "images/resource/02.png", "url" => "javascript:;"],
            ["image" => "images/resource/03.png", "url" => "javascript:;"],
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

    public static function weChatShare($shareUrl)
    {
        $result = Base::http(
            env('API_URL') . '/mall/share/wechat',
            [
                'share_url' => $shareUrl,
            ],
            [],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }
    }
}