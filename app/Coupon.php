<?php

namespace App;

use App\Exceptions\BusinessException;

class Coupon
{
    public static $resourceUrl = '/promotion/coupons';

    public static function getCoupons($productId)
    {
        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
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

        return $result->data;
    }

    public static function getMemberCoupons($status)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/by-member', self::$resourceUrl),
            [
                'status' => $status
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return $result->data;
    }

    public static function saveCoupon($couponId)
    {
        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [
                'coupon_id' => $couponId
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return true;
    }

    /**是否可用优惠券
     * @param $productId
     * @return mixed
     * @throws BusinessException
     */
    public static function hasProductCoupon($productId)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/has-product', self::$resourceUrl),
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

        return $result->data;
    }
}
