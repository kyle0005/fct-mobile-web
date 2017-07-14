<?php

namespace App;

use App\Exceptions\BusinessException;

class Coupon
{
    public static function getCoupons($productId)
    {
        $result = Base::http(
            env('API_URL') . '/promotion/coupons',
            [
                'product_id' => $productId
            ],
            [],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return [
            'title' => '优惠券列表 - 方寸堂',
            'coupons' => json_encode($result->data, JSON_UNESCAPED_UNICODE),
        ];
    }

    public static function getCoupon()
    {

    }

    public static function saveCoupon()
    {

    }
}
