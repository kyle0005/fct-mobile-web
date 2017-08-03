<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-6-29
 * Time: 下午6:44
 */

namespace App;


use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Crypt;

class ProductOrder
{
    public static $resourceUrl = '/mall/orders';

    /**获取订单列表
     * @param $orderId
     * @param $status
     * @param int $pageIndex
     * @return array|bool|object
     */
    public static function getOrders($orderId, $status, $commentStatus, $pageIndex = 1)
    {
        $commentStatuses = [0, 1];
        $statuses = [0,1,2,3,4];
        if (!in_array($commentStatus, $commentStatuses))
        {
            $commentStatus = -1;
        }
        if (!in_array($status, $statuses))
        {
            $status = -1;
        }

        $pageSize = 20;
        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [
                'order_id' => $orderId,
                'status' => $status,
                'comment_status' => $commentStatus,
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

        $pagination = Base::pagination($result->data, $pageSize);

        return $pagination;
    }

    /**获取订单详情
     * @param $orderId
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public static function getOrder($orderId)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/%s', self::$resourceUrl, $orderId),
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
    public static function saveOrder($shopId, $points, $accountAmount, $couponCode, $remark, $addressId, $orderGoodsInfo)
    {
        if (!$orderGoodsInfo)
        {
            throw new BusinessException("提交的订单产品不存在");
        }

        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [
                'shopId' => $shopId,
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
            throw new BusinessException($result->msg);
        }

        return $result->data;
    }

    /**取消订单
     * @param $orderId
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     * @throws BusinessException
     */
    public static function cancelOrder($orderId)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/%s/cancel', self::$resourceUrl, $orderId),
            [
                'order_id' => $orderId,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return $result;
    }

    /**订单订单价格
     * @param $productInfo
     * @param $accountAmount
     * @param $points
     * @param $couponCode
     */
    public static function checkoutOrderGoods($productInfo)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/products', self::$resourceUrl),
            [
                'orderProductInfo' => json_encode($productInfo, JSON_UNESCAPED_UNICODE),
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        if ((!$result->data) || (!$result->data->goodsList))
        {
            throw new BusinessException("数据异常");
        }

        return [
            'title' => '订单确认',
            'address' => json_encode($result->data->address ,JSON_UNESCAPED_UNICODE),
            'products' => json_encode($result->data->goodsList ,JSON_UNESCAPED_UNICODE),
            'submitCouponProducts' => Crypt::encryptString(json_encode($result->data->couponGoodsList ,JSON_UNESCAPED_UNICODE)),
            'coupon' => json_encode($result->data->coupon ,JSON_UNESCAPED_UNICODE),
            'points' => $result->data->points,
            'availableAmount' => $result->data->availableAmount,
        ];
    }

    /**获取订单商品
     * @param $id
     * @return mixed
     * @throws BusinessException
     */
    public static function getOrderProduct($id)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/products/%d', self::$resourceUrl, $id),
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
}