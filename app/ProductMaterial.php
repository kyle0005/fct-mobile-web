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
    public static function getMaterialsByIds($materialIds, $productId)
    {
        $result = Base::http(
            env('API_URL') . '/materials/by-product',
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