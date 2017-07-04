<?php

namespace App\Http\Controllers\Mobile;

use App\Exceptions\BusinessException;
use App\ShoppingCart;
use Illuminate\Http\Request;

/**购物车
 * Class ShoppingCartController
 * @package App\Http\Controllers\Mobile
 */
class ShoppingCartController extends BaseController
{
    public function index(Request $request)
    {
        try{

            $result = ShoppingCart::getShoppingCarts();
            print_r($result);die;
        } catch (BusinessException $e) {

            return $this->errorPage($e->getMessage());
        }

        return view('cart.index');
    }

    public function store(Request $request)
    {
        $productId = intval($request->get('product_id', 0));
        $buyNumber = intval($request->get('buy_number', 0));
        $extendId = intval($request->get('spec_id', 0));

        if ($productId < 1) {
            return $this->returnAjaxError('添加的产品不存在');
        }
        if ($buyNumber < 1) {
            return $this->returnAjaxError('产品数量不能小于1');
        }

        try {

            ShoppingCart::saveShoppingCart($productId, $extendId, $buyNumber);
            return $this->returnAjaxSuccess('添加购物车成功');
        } catch (BusinessException $e) {

            return $this->returnAjaxError($e->getMessage());
        }

    }

    public function setDelete(Request $request, $id)
    {
        try {

            ShoppingCart::remove($id);

            return $this->returnAjaxSuccess('从购物车删除产品成功');
        } catch (BusinessException $e) {

            return $this->returnAjaxError($e->getMessage());
        }
    }
}
