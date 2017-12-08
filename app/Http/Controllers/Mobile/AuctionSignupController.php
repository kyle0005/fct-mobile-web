<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-12-5
 * Time: 上午10:43
 */

namespace App\Http\Controllers\Mobile;


use App\AuctionSignup;
use App\Exceptions\BusinessException;
use Illuminate\Http\Request;

class AuctionSignupController extends BaseController
{
    public function index(Request $request)
    {
        $goodsName = $request->get('goods_name', '');
        $status = $request->get('status', -1);
        $page = $request->get('page', 1);
        try
        {
            $result = AuctionSignup::getSignups($goodsName, $status, $page);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess("获取成功", null, $result);

        return view('auction.signup.index', [
            'title' => fct_title('我的拍卖'),
            'status' => $status,
            'signups' => $result
        ]);
    }

    public function store(Request $request)
    {
        $productId = intval($request->get('goods_id'));
        if ($productId < 1) {
            return $this->autoReturn('拍品ID不存在', 404);
        }

        try
        {
            $result = AuctionSignup::saveSignup($productId, $this->getShopId());
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        if (!$result)
            return $this->autoReturn('报名异常');

        return $this->returnAjaxSuccess("报名提交成功",
            sprintf('%s?tradetype=auction_deposit&tradeid=%s', env('PAY_URL'), $result));
    }
}