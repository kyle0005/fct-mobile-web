<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-3
 * Time: 上午11:02
 */

namespace App;


use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Cache;

class ProductCategory
{

    public static $resourceUrl = '/mall/products';

    public static function getCategories()
    {
        $cacheKey = 'product_categories';
        $cacheTime = 30;
        $cacheResult = false;

        if (Cache::has($cacheKey)) {
            $cacheResult = Cache::get($cacheKey);
        }

        if (!$cacheResult) {
            $result = Base::http(
                env('API_URL') . sprintf('%s/categories', self::$resourceUrl),
                [],
                [],
                'GET'
            );

            if ($result->code != 200) {
                throw new BusinessException($result->msg);
            }

            $categories = [
                (object)['name' => '全部', 'code' => ""],
            ];
            $cacheResult = $result->data ? array_merge($categories, $result->data) : $categories;
            Cache::put($cacheKey, $cacheResult, $cacheTime);
        }

        return $cacheResult;
    }
}