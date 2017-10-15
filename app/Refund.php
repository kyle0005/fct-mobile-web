<?php

namespace App;
use App\Exceptions\BusinessException;

/**退款
 * Class Refund
 * @package App
 */
class Refund
{
    public static $resourceUrl = '/mall/refunds';

    public static function getRefunds($orderProductId, $page)
    {
        $pageIndex = $page < 1 ? 1 : $page;
        $pageSize = 20;

        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [
                'order_product_id' => $orderProductId,
                'page_index' => $pageIndex,
                'page_size' => $pageSize,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        $pagination = Base::pagination($result->data, $pageIndex, $pageSize);

        return $pagination;
    }

    public static function getRefund($id)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/%d', self::$resourceUrl, $id),
            [],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return $result->data;
    }

    /*String order_id, Integer order_product_id, Integer service_type,
                                  String reason, String description, String images*/
    public static function saveRefund($orderId, $orderProductId, $serviceType, $reason, $description, $images)
    {
        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [
                'order_id' => $orderId,
                'order_product_id' => $orderProductId,
                'service_type' => $serviceType,
                'reason' => $reason,
                'description' => $description,
                'images' => $images,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return $result->data;
    }

    public static function refundExpress($id, $expressName, $expressNumber)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/%d/express', self::$resourceUrl, $id),
            [
                'id' => $id,
                'express_name' => $expressName,
                'express_number' => $expressNumber,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return $result->data;
    }

    public static function cancel($id)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/%d/close', self::$resourceUrl, $id),
            [
                'id' => $id,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return $result->data;
    }

}
