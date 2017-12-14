<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-5
 * Time: 下午7:07
 */

namespace App;


use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Cache;

class ProductMaterial
{
    public static $resourceUrl = '/mall/materials';

    public static function getMaterialAndProducts($id, $productId = 0)
    {
        $cacheKey = 'materials_' . $id .'_products';
        $cacheTime = 30;
        $cacheResult = false;

        if (Cache::has($cacheKey))
        {
            $cacheResult = Cache::get($cacheKey);
        }

        if (!$cacheResult) {
            $result = Base::http(
                env('API_URL') . sprintf('%s/%d/products', self::$resourceUrl, $id),
                [],
                [],
                'GET'
            );

            if ($result->code != 200) {
                throw new BusinessException($result->msg, $result->code);
            }

            $cacheResult = $result->data;
            Cache::put($cacheKey, $cacheResult, $cacheTime);
        }

        if ($cacheResult && $cacheResult->products) {
            $products = [];
            $temp = 0;
            foreach ($cacheResult->products as $product) {
                if ($product->id != $productId)
                {
                    $products[] = $product;
                    $temp++;
                }

                if ($temp == 3)
                    break;
            }
            $cacheResult->products = $products;
        }

        return $cacheResult;
    }

    public static function getMaterialsByIds($materialIds, $productId)
    {
        if (!$materialIds)
            throw new BusinessException('守艺人不存在');

        $idArr = explode(',', $materialIds);
        if (!$materialIds)
            throw new BusinessException('守艺人不存在');

        $materials = [];
        foreach ($idArr as $value)
        {
            $materials[] = self::getMaterialAndProducts($value, $productId);
        }


        return $materials;
    }
}