<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-6-22
 * Time: 下午1:53
 */

namespace App;


class Artist
{

    public static function getRows()
    {
        return [
            (object)[
                'name' => '顾景舟',
                'image' => '/images/photos/12/12312.jpg',
                'win_title' => '紫砂第一人',
                'followed' => 123456,
                'product' => 99,
                'description' => '紫砂第一人紫砂第一人紫砂第一人紫砂第一人紫砂第一人紫砂第一人紫砂第一人紫砂第一人紫砂第一人',
            ]
        ];
    }

    public static function getRow($id)
    {
        $row = (object)[
            'image' => 'xxxxxx',
            'description' => 'xxxxxxxxxxxx',

            'items' => [
                (object) [
                    'content' => 'xxxx',
                    'image' => 'xxxxxx',
                    'vod' => 'xxxx,xxx',
                    'vod_image' => '',
                ]
            ]

        ];
    }
}