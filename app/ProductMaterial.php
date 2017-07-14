<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-5
 * Time: 下午7:07
 */

namespace App;


use App\Exceptions\BusinessException;

class ProductMaterial
{
    public static $resourceUrl = '/mall/materials';

    public static function getMaterialsByIds($materialIds, $productId)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/by-product', self::$resourceUrl),
            [
                'product_id' => $productId,
                'ids' => $materialIds,
            ],
            [],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return $result->data;
    }
}