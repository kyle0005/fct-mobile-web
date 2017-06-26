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
        $result = (object)[];
        $result->links = (object)[
            'artist' => ['name' => '合作大师', icon => '', 'url' => ''],
            'wiki' => ['name' => '百科', icon => '', 'url' => ''],
            'custom' => ['name' => '个性定制', icon => '', 'url' => ''],
            'download' => ['name' => 'APP下载', icon => '', 'url' => ''],
            'brand' => ['name' => '品牌理念', icon => '', 'url' => ''],
        ];

        return $result;
    }

    public static function welcome()
    {
        return  [
            'mall' => (object)['name' => '进入商城', 'url' => 'xxxx'],
            'download' =>  (object)['name' => '下载APP', 'url' => 'xxxx'],
            'images' => [
                (object)['image' => 'xxxxx', 'url' =>'xxxxx'],
                (object)['image' => 'xxxxx', 'url' =>'xxxxx'],
            ]
        ];
    }
}