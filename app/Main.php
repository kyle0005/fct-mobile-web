<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-6-22
 * Time: 下午3:31
 */

namespace App;


class Main
{
    public static function index()
    {
        $result = [];
        $result['links'] = (object)[
            'artist' => ['name' => '合作大师', 'icon' => '', 'url' => ''],
            'wiki' => ['name' => '百科', 'icon' => '', 'url' => ''],
            'custom' => ['name' => '个性定制', 'icon' => '', 'url' => ''],
            'download' => ['name' => 'APP下载', 'icon' => '', 'url' => ''],
            'brand' => ['name' => '品牌理念', 'icon' => '', 'url' => ''],
        ];
        $result['title'] = '方寸堂';

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
            'title' => '欢迎使用方寸堂',
            'slides' => json_encode($slides, JSON_UNESCAPED_UNICODE),
        ];

    }
}