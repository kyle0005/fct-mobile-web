<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-6-22
 * Time: 下午3:31
 */

namespace App;


class Home
{
    public static function getHome($categoryId = 1, $levelId = 1, $pageIndex = 1)
    {
        $pageSize = 10;
        $result = Base::http(
            env('API_URL') . '/home',
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
            return false;
        }
        $categories = [
            (object)['name' => '全部', 'code' => ""],
        ];

        $pagination = Base::pagination($result->data->goodsList, $pageSize);

        return [
            'title' => '方寸堂',
            'categories' => json_encode(array_merge($categories, $result->data->categoryList), JSON_UNESCAPED_UNICODE),
            'levels' =>  json_encode($result->data->goodsGradeList, JSON_UNESCAPED_UNICODE),
            'products' => json_encode($pagination->entries, JSON_UNESCAPED_UNICODE),
            'pager' => json_encode($pagination->pager, JSON_UNESCAPED_UNICODE),
        ];
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
            'title' => '欢迎使用方寸堂',
            'slides' => json_encode($slides, JSON_UNESCAPED_UNICODE),
        ];

    }
}