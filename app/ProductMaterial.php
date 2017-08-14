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

    public static function getMaterialsByIds($materialIds, $productId)
    {
        $cacheKey = 'materials_product_' . $productId;
        $cacheTime = 30;
        $cacheResult = false;

        if (Cache::has($cacheKey)) {
            $cacheResult = Cache::get($cacheKey);
        }

        if (!$cacheResult) {
            $result = Base::http(
                env('API_URL') . sprintf('%s/by-product', self::$resourceUrl),
                [
                    'product_id' => $productId,
                    'ids' => $materialIds,
                ],
                [],
                'GET'
            );

            if ($result->code != 200) {
                throw new BusinessException($result->msg);
            }

            $cacheResult = $result->data;
            Cache::put($cacheKey, $cacheResult, $cacheTime);
        }

        return $cacheResult;
    }
}