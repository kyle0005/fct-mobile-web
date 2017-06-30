<?php

namespace App\Http\Controllers\Mobile;

use App\Exceptions\BusinessException;
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
        return view('order.index');
    }

    public function show(Request $request, $order_id)
    {
        return view('order.show');
    }

    public function create(Request $request)
    {
        $productId = $request->get('product_id', 0);
        $buyNumber = $request->get('buy_number', 0);
        $extendId = 0;
        $cartProducts = $request->get('cart_products', '');
        $productInfo = [];


        //直接购买
        if ($productId && $buyNumber)
        {
            $extendId = $request->get('extend_id', 0);
            $productInfo[] = [
                'goodsId' =>$productId,
                'goodsSpecId' => $extendId,
                'buyCount' => $buyNumber,
            ];
        }
        //购物车中选择选择购买
        elseif ($cartProducts)
        {
            foreach ($cartProducts as $cartProduct)
            {
                $productId = intval($cartProduct['product_id']);
                $buyNumber = intval($cartProduct['extend_id']);
                $extendId = intval($cartProduct['buy_number']);
                if ($productId <= 0 || $buyNumber <= 0)
                {
                    throw new BusinessException("购物车中的产品不存在或数量不能小于1个");
                }

                $productInfo[] = [
                    'goodsId' =>$productId,
                    'SpecId' => $extendId,
                    'buyCount' => $buyNumber,
                ];
            }
        }
        //非法操作
        else
        {
            return $this->returnAjaxError('非法操作');
        }

        $order = ProductOrder::calc($productInfo);




        return view('order.create');
    }

    public function store(Request $request)
    {
        $points = $request->get('points');
        $accountAmount = $request->get('account_amount');
        $couponCode = $request->get('coupon_code');
        $remark = $request->get('remark');
        $addressId = $request->get('address_id');
        $orderGoodsInfo = $request->get('goods_info'); //json



    }
}
