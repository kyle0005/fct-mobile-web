<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-3
 * Time: 上午11:02
 */

namespace App;


use App\Exceptions\BusinessException;

class ProductCategory
{

    public static $resourceUrl = '/mall/products';

    public static function getCategories()
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/categories', self::$resourceUrl),
            [],
            [],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        $categories = [
            (object)['name' => '全部', 'code' => ""],
        ];
        return $result->data ? array_merge($categories, $result->data) : $categories;
    }
}