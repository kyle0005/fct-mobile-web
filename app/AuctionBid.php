<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-11-27
 * Time: 下午2:05
 */

namespace App;


use App\Exceptions\BusinessException;

class AuctionBid
{

    public static $resourceUrl = '/auction/bid';

    public static function saveBid($productId, $price)
    {
        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [
                'goods_id' => $productId,
                'price' => $price,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg, $result->code);
        }

        return $result->data;
    }

}