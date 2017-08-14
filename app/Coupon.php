<?php

namespace App;

use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Cache;

class Coupon
{
    public static $resourceUrl = '/promotion/coupons';

    public static function getCoupons($productId)
    {
        $cacheKey = 'coupons_product_' . $productId;
        $cacheTime = 30;
        $cacheResult = false;

        if (Cache::has($cacheKey))
        {
            $cacheResult = Cache::get($cacheKey);
        }

        if (!$cacheResult) {

            $result = Base::http(
                env('API_URL') . self::$resourceUrl,
                [
                    'product_id' => $productId
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

    public static function getMemberCoupons($status)
    {
        $member = Member::getAuth();
        $cacheKey = 'member_' . $member->memberId . '_coupons_status_' . $status;
        $cacheTime = 30;
        $cacheResult = false;

        if (Cache::has($cacheKey))
        {
            $cacheResult = Cache::get($cacheKey);
        }

        if (!$cacheResult) {
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

            $cacheResult = $result->data;

            Cache::put($cacheKey, $cacheResult, $cacheTime);
        }

        return $cacheResult;
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

    /**使用优惠券
     * @param $code
     */
    public static function useCoupon($code, $productInfo)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/use', self::$resourceUrl),
            [
                'code' => $code,
                'product_info' => $productInfo,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return $result->data;
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
