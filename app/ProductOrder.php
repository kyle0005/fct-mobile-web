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
    /**获取订单列表
     * @param $orderId
     * @param $status
     * @param int $pageIndex
     * @return array|bool|object
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

    /**获取订单详情
     * @param $orderId
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     */
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

    /**保存订单
     * @param $points
     * @param $accountAmount
     * @param $couponCode
     * @param $remark
     * @param $addressId
     * @param $orderGoodsInfo //[{goodsId:1,goodsSpecId:1,buyCount:2}...]
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     * @throws BusinessException
     */
    public static function saveOrder($points, $accountAmount, $couponCode, $remark, $addressId, $orderGoodsInfo)
    {
        if (!$orderGoodsInfo)
        {
            throw new BusinessException("提交的订单产品不存在");
        }

        $result = Base::http(
            env('API_URL') . '/orders',
            [
                'points' => $points,
                'accountAmount' => $accountAmount,
                'couponCode' => $couponCode,
                'remark' => $remark,
                'addressId' => $addressId,
                'orderGoodsInfo' => json_encode($orderGoodsInfo, JSON_UNESCAPED_UNICODE),
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->message);
        }

        return $result;
    }

    /**取消订单
     * @param $orderId
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     * @throws BusinessException
     */
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

    /**订单订单价格
     * @param $productInfo
     * @param $accountAmount
     * @param $points
     * @param $couponCode
     */
    public static function calc($productInfo, $accountAmount = 0, $points = 0, $couponCode = "")
    {
        $result = Base::http(
            env('API_URL') . '/orders/order-products',
            [
                'orderProductInfo' => json_encode($productInfo, JSON_UNESCAPED_UNICODE),
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->message);
        }

        if (!$result->data)
        {
            throw new BusinessException("数据异常");
        }

        $result;
    }
}