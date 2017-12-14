<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-11-27
 * Time: 下午2:48
 */

namespace App;


use App\Exceptions\BusinessException;

class AuctionRemind
{

    public static $resourceUrl = '/auction/remind';

    public static function saveRemind($productId)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/set', self::$resourceUrl),
            [
                'goods_id' => $productId,
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