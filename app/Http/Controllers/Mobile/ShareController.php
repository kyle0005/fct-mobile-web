<?php

namespace App\Http\Controllers\Mobile;

use App\Exceptions\BusinessException;
use App\Product;
use App\ProductCategory;
use App\ProductOrder;
use Illuminate\Http\Request;

class ShareController extends BaseController
{
    public function index(Request $request)
    {
        $code = $request->get('code', '');
        $name = $request->get('keyword', '');
        $sortIndex = intval($request->get('sort', 0));
        $page = intval($request->get('page', 1));

        try
        {

            $result = Product::getShareProducts($code, $name, $sortIndex, $page);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess('获取成功', null, $result);

        return view('share.index', [
            'title' => fct_title('分享'),
            'categories' => ProductCategory::getCategories(),
            'entries' => $result,
        ]);
    }

    public function getOrders(Request $request)
    {
        $keyword = $request->get('keyword', '');
        $status = $request->get('status', -1);
        $page = $request->get('page', 1);
        try
        {
            $result = ProductOrder::getShopOrders($keyword, $status, $page);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess("获取成功", null, $result);

        return view('share.order-index', [
            'title' => fct_title('我的订单'),
            'status' => $status,
            'orderlist' => $result
        ]);
    }

    public function getOrder(Request $request, $order_id)
    {
        try
        {
            $result = ProductOrder::getShopOrder($order_id);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        return view('share.order-show', [
            'title' => fct_title('订单详情'),
            'entity' => $result,
        ]);
    }
}
