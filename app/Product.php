<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-6-22
 * Time: 下午3:39
 */

namespace App;


class Product
{
    public static function getProduct($id)
    {
        $result = Base::http(
            env('API_URL') . sprintf('/products/%d', $id),
            [],
            [],
            'GET'
        );

        if ($result->code != 200)
        {
            return false;
        }

        $product = $result->data;

        return [
            'title' => (isset($product->name) && $product->name ? $product->name : '产品详情') . '方寸堂',
            'product' => json_encode($product, JSON_UNESCAPED_UNICODE),
        ];
    }
}