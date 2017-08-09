<?php

namespace App\Http\Controllers\Mobile;

use App\Exceptions\BusinessException;
use App\FctCommon;
use App\ProductOrder;
use Illuminate\Http\Request;

/**订单
 * Class OrderController
 * @package App\Http\Controllers\Mobile
 */
class OrderController  extends BaseController
{
    public function index(Request $request)
    {
        $keyword = $request->get('keyword', '');
        $status = $request->get('status', -1);
        $commentStatus = $request->get('status', -1);
        $page = $request->get('page', 1);
        try
        {
            $result = ProductOrder::getOrders($keyword, $status, $commentStatus, $page);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess("获取成功", null, $result);

        return view('order.index', [
            'title' => '我的订单',
            'status' => $status,
            'orderlist' => $result
        ]);
    }

    public function show(Request $request, $order_id)
    {
        try
        {
            $result = ProductOrder::getOrder($order_id);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        return view('order.show', [
            'title' => '订单详情',
            'entity' => $result,
        ]);
    }

    public function create(Request $request)
    {
        $productId = intval($request->get('product_id', 0));
        $buyNumber = intval($request->get('buy_number', 0));
        $cartProducts = json_decode($request->get('product', ''), true);
//        $cartProducts = json_decode(FctCommon::fctBase64Decode($request->get('product', '')), true);
        $productInfo = [];

        //直接购买
        if ($productId && $buyNumber)
        {
            $extendId = intval($request->get('spec_id', 0));
            $productInfo[] = [
                'goodsId' =>$productId,
                'specId' => $extendId,
                'buyCount' => $buyNumber,
            ];
            if ($productId < 1 || $buyNumber <= 0)
            {
                return $this->autoReturn("产品不存在或数量小于1");
            }
        }

        //购物车中选择选择购买
        elseif ($cartProducts)
        {
            foreach ($cartProducts as $cartProduct)
            {
                $productId = intval($cartProduct['goodsId']);
                $extendId = intval($cartProduct['specId']);
                $buyNumber = intval($cartProduct['buyCount']);
                if ($productId < 1 || $buyNumber <= 0)
                {
                    return $this->autoReturn("购物车中的产品不存在或数量小于1");
                }

                $productInfo[] = [
                    'goodsId' =>$productId,
                    'specId' => $extendId,
                    'buyCount' => $buyNumber,
                ];
            }
        }
        //非法操作
        else
        {
            return $this->autoReturn('非法操作');
        }

        try
        {
            $result = ProductOrder::checkoutOrderGoods($productInfo);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        $result[env('REDIRECT_KEY')] = urlencode($request->getUri());
        return view('order.create', $result);
    }

    public function store(Request $request)
    {
        $hasTerms = $request->get('has_terms');
        if (!$hasTerms)
        {
            return $this->autoReturn("请先同意协议才能购买");
        }

        $points = intval($request->get('points'));
        $points = $points <= 0 ? 0 : $points;

        $accountAmount = floatval($request->get('accountAmount'));
        $accountAmount = $accountAmount <= 0 ? 0 : $accountAmount;

        $couponCode = $request->get('couponCode');
        $remark = $request->get('remark');
        $addressId = intval($request->get('addressId'));

        $orderGoodsInfo = $request->get('orderGoodsInfo', '');
        if (!$orderGoodsInfo)
        {
            return $this->autoReturn("没找到需下单的产品");
        }
        $orderGoodsInfo = json_decode($orderGoodsInfo);

        try
        {
            $result = ProductOrder::saveOrder($this->getShopId(), $points, $accountAmount, $couponCode,
                $remark, $addressId, $orderGoodsInfo);

            if (!$result)
                return $this->autoReturn('生成订单异常');

            return $this->returnAjaxSuccess("订单创建成功",
                sprintf('%s?tradetype=buy&tradeid=%s', env('PAY_URL'), $result));
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }

    /**取消订单
     * @param Request $request
     * @param $order_id
     * @return string
     */
    public function setCancel(Request $request, $order_id)
    {
        try
        {
            ProductOrder::cancelOrder($order_id);

            $url = url('my/orders');
            if (strpos($request->server('HTTP_REFERER'), '/orders/') !== false) {
                $url .= '/'. $order_id;
            }
            return $this->returnAjaxSuccess('订单取消成功', $url);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }

    /**确认收货
     * @param Request $request
     * @param $order_id
     * @return string
     */
    public function setFinish(Request $request, $order_id)
    {
        try
        {
            ProductOrder::finishOrder($order_id);

            $url = url('my/orders');
            if (strpos($request->server('HTTP_REFERER'), '/orders/') !== false) {
                $url .= '/'. $order_id;
            }

            return $this->returnAjaxSuccess('确认收货成功', $url);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }

}
