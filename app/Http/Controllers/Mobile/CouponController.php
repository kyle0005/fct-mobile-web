<?php

namespace App\Http\Controllers\Mobile;

use App\Coupon;
use App\Exceptions\BusinessException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

/**优惠券
 * Class CouponController
 * @package App\Http\Controllers\Mobile
 */
class CouponController extends BaseController
{
    public function index(Request $request)
    {
        $status = intval($request->get('status', 0));
        try
        {
            $result = Coupon::getMemberCoupons($status);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess('获取成功', null, $result->couponList);

        return view('coupon.index', [
            'title' => '我的优惠券',
            'coupons' => $result->couponList,
            'canReceiveCount' => $result->canReceiveCount,
        ]);

    }

    public function store(Request $request)
    {
        $id = intval($request->get('id', 0));
        if ($id < 1) {
            return $this->autoReturn('无效的优惠券');
        }

        try
        {
            Coupon::saveCoupon($id);
            return $this->returnAjaxSuccess('领取成功');
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }

    public function useCoupon(Request $request)
    {
        $code = $request->get('couponCode', '');
        $productInfo = $request->get('validateCoupon', '');
        if (!$code)
        {
            return $this->autoReturn('无效的优惠券');
        }

        if (!$productInfo)
        {
            return $this->autoReturn('无效的产品');
        }

        $productInfo = Crypt::decryptString($productInfo);
        if (!$productInfo)
        {
            return $this->autoReturn('无效的产品');
        }
        if (!json_decode($productInfo))
        {
            return $this->autoReturn('无效的产品');
        }

        try
        {
            $amount = Coupon::useCoupon($code, $productInfo);
            return $this->returnAjaxSuccess('有效的优惠券', null, $amount);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }
}
