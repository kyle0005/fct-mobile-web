<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-11-28
 * Time: 下午2:17
 */

namespace App\Http\Controllers\Mobile;


use App\AuctionOrder;
use App\Exceptions\BusinessException;
use Illuminate\Http\Request;

class AuctionOrderController extends BaseController
{

    public function index(Request $request) {
        $keyword = $request->get('keyword', '');
        $status = $request->get('status', -1);
        $page = $request->get('page', 1);
        try
        {
            $result = AuctionOrder::getOrders($keyword, $status, $page);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess("获取成功", null, $result);

        return view('auction.order.index', [
            'title' => fct_title('我的拍卖订单'),
            'status' => $status,
            'orders' => $result
        ]);
    }

    public function show(Request $request, $order_id) {
        $from = $request->get('from', '');
        if (!$order_id) {
            return $this->autoReturn('拍品订单不存在', 404);
        }
        try
        {
            $result = AuctionOrder::getOrder($order_id, $from);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        return view('auction.order.show', [
            'title' => fct_title('订单详情'),
            'entity' => $result,
        ]);
    }

    public function store(Request $request) {
        $signupId = intval($request->get('signup_id'));
        $addressId = intval($request->get('address_id'));
        $accountAmount = floatval($request->get('account_amount'));
        $points = intval($request->get('points'));
        $remark = $request->get('remark');

        try
        {
            $result = AuctionOrder::saveOrder($signupId, $addressId, $accountAmount, $points, $remark);
            if (!$result)
                return $this->autoReturn('生成订单异常');

            return $this->returnAjaxSuccess("订单提交成功",
                sprintf('%s?tradetype=auction_order&tradeid=%s', env('PAY_URL'), $result));
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }
    }

    public function create(Request $request) {

        $signupId = $request->get('signupid');
        if (!$signupId) {
            return $this->autoReturn('报名ID不存在', 404);
        }
        try
        {
            $result = AuctionOrder::createOrder($signupId);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        return view('auction.order.form', [
            'title' => fct_title('订单详情'),
            'address' => $result->address,
            'product' => $result->goods,
            'points' => $result->points,
            'amount' => $result->amount,
            'signupId' => $signupId,
            env('REDIRECT_KEY') => urlencode($request->getUri())
        ]);
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
            AuctionOrder::createOrder($order_id);

            $url = url('my/auction/order', [], env('APP_SECURE'));
            if (strpos($request->server('HTTP_REFERER'), '/order/') !== false) {
                $url .= '/'. $order_id;
            }

            return $this->returnAjaxSuccess('确认收货成功', $url);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }
    }
}