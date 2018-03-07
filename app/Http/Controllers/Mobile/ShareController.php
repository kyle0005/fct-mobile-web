<?php

namespace App\Http\Controllers\Mobile;

use App\AuctionOrder;
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
            'homeShareUrl' => "https://pan.baidu.com/share/qrcode?w=300&h=300&url="
                . urlencode($this->myShareUrl(url('/', [], env('APP_SECURE') . '/')))
        ]);
    }

    public function show(Request $request, $id)
    {
        $id = intval($id);
        $title = "";
        if ($id > 0) {
            try {
                $result = Product::getShareProduct($id);
            } catch (BusinessException $e) {
                return $this->autoReturn($e->getMessage(), $e->getCode());
            }

            $title = $result->name;
            $result->headPortrait = image_base64($result->headPortrait);
            $result->defaultImage = image_base64($result->defaultImage);
            $result->qrcodeUrl = image_base64("https://pan.baidu.com/share/qrcode?w=300&h=300&url="
                . urlencode($this->myShareUrl(url('/', [], env('APP_SECURE') . '/products/' . $result->id))));
        } else {
            $title = '方寸堂';
            $result = (object) [
                'qrcodeUrl' => image_base64("https://pan.baidu.com/share/qrcode?w=300&h=300&url="
                    . urlencode($this->myShareUrl(url('/', [], env('APP_SECURE') . '/')))),
                'backgroundUrl' => image_base64(fct_cdn('/img/mobile/share_bg')),
            ];
        }
        return view('share.show', [
            'title' => fct_title('分享' . $title),
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

    public function getAuctionOrders(Request $request)
    {
        $keyword = $request->get('keyword', '');
        $status = $request->get('status', -1);
        $page = $request->get('page', 1);
        try
        {
            $result = AuctionOrder::getOrders($keyword, $status, $page, 'shop');
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess("获取成功", null, $result);

        return view('share.auctionorder-index', [
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
