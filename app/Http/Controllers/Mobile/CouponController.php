<?php

namespace App\Http\Controllers\Mobile;

use App\Coupon;
use App\Exceptions\BusinessException;
use Illuminate\Http\Request;

/**优惠券
 * Class CouponController
 * @package App\Http\Controllers\Mobile
 */
class CouponController extends BaseController
{
    public function index(Request $request)
    {
        $productId = $request->get('product_id', 0);
        try
        {
            $result = Coupon::getMemberCoupons($productId);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        return view('coupon.index', [
            'title' => '我的优惠券',
            'coupons' => $result,
        ]);

    }

    public function show(Request $request, $id)
    {

    }

    public function store(Request $request)
    {

    }
}
