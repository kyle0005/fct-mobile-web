<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-6-29
 * Time: 下午6:44
 */

namespace App;


use App\Exceptions\BusinessException;

class ProductOrder
{

    /*     * @param points
     * @param accountAmount
     * @param orderGoodsInfo //[{goodsId:1,goodsSpecId:1,buyCount:2}...]
     * @param couponCode
     * @param remark
     * @param orderReceiverInfo //{name:张三, phone:13812345678, province:上海, city:上海, region:静安, address:长寿路1号 postCode:}
     *
     */

    public static function getOrders($orderId, $status, $pageIndex = 1)
    {
        $pageSize = 20;
        $result = Base::http(
            env('API_URL') . '/orders',
            [
                'order_id' => $orderId,
                'status' => $status,
                'page_index' => $pageIndex,
                'page_size' => $pageSize,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            return false;
        }

        $pagination = Base::pagination($result->data->goodsList, $pageSize);

        return $pagination;
    }

    public static function getOrder($orderId)
    {
        $result = Base::http(
            env('API_URL') . sprintf('/orders/%s', $orderId),
            [],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        return $result;
    }

    public static function saveOrder($orderId)
    {
        $result = Base::http(
            env('API_URL') . '/orders',
            [
                'order_id' => $orderId,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->message);
        }

        return $result;
    }

    public static function cancelOrder($orderId)
    {
        $result = Base::http(
            env('API_URL') . sprintf('/orders/%s/cancel', $orderId),
            [
                'order_id' => $orderId,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->message);
        }

        return $result;
    }
}