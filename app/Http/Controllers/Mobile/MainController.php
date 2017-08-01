<?php

namespace App\Http\Controllers\Mobile;

use App\Base;
use App\Coupon;
use App\Exceptions\BusinessException;
use App\FctCommon;
use App\FctValidator;
use App\Main;
use App\ProductCategory;
use Illuminate\Http\Request;

/**默认入口页面
 * Class MainController
 * @package App\Http\Controllers\Mobile
 */
class MainController extends BaseController
{
    /**商城首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //?code={code}&level_id={id}
        $categoryId = $request->get('code');
        $levelId = $request->get('level_id');
        $pageIndex = $request->get('page', 1);

        try
        {
            $result = Main::getHome($categoryId, $levelId, $pageIndex);
        }
        catch (BusinessException $e)
        {
            //错误处理
            return $this->autoReturn($e->getMessage());
        }

        if ($request->ajax())
        {
            return $this->returnAjaxSuccess($request->message, "", $result->pagination->entries);
        }
        else
        {

            $shareUrl = url('/');
            $shopId = intval($request->get(env('SHARE_SHOP_ID_KEY')));
            if ($shopId > 0) {
                $this->setShopId();
                $shareUrl = $shareUrl . '?'.env('SHARE_SHOP_ID_KEY').'=' .$shopId;
            }

            return view('index', [
                'title' => '方寸网',
                'categories' => ProductCategory::getCategories(),
                'levels' =>  $result->goodsGradeList,
                'products' => $result->pagination->entries,
                'pager' => $result->pagination->pager,
                ]);
        }
    }

    /**欢迎页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome(Request $request)
    {
        $result = Main::welcome();

        return view('welcome', $result);
    }

    public function sendCaptcha(Request $request)
    {
        $cellphone = $request->get('cellphone');
        $action = $request->get('action');

        try {

            FctValidator::hasMobile($cellphone);

            $sessionId = FctCommon::createMobileSessionId();
            $result = Base::sendCaptcha($cellphone, $sessionId, $request->ip(), $action);

            $this->returnAjaxSuccess($result->msg);

        } catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }

    public function newCoupon(Request $request)
    {
        $productId = $request->get('product_id', 0);
        try
        {
            $result = Coupon::getCoupons($productId);
        } catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        return view('coupon.new', [
            'title' => '优惠券列表 - 方寸网',
            'coupons' => $result,
        ]);
    }

    public function findExpress(Request $request, $express_number)
    {

        return view('express');
    }

    public function weChatShare(Request $request)
    {
        $shareUrl = $request->get('share_url', '');
        if (!$shareUrl)
        {
            return '';
        }
        try
        {
            $result = Main::weChatShare($shareUrl);
            return $result;
        }
        catch (BusinessException $e)
        {
            return "";
        }
    }

    public function downloadApp(Request $request)
    {
        return view('download-app');
    }

    public function error(Request $request)
    {
        $message = $request->get('message', '');

        $redirectUrl = $request->get(env('REDIRECT_KEY'), '');

        return $this->errorPage($message, $redirectUrl);
    }

}
