<?php

namespace App\Http\Controllers\Mobile;

use App\Exceptions\BusinessException;
use App\FctCommon;
use App\FctValidator;
use App\ProductOrder;
use App\Refund;
use Illuminate\Http\Request;

class RefundController extends BaseController
{
    public function index(Request $request)
    {
        $orderProductId = $request->get('og_id', 0);
        $page = $request->get('page', 1);
        try
        {
            $result = Refund::getRefunds($orderProductId, $page);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess("成功", null, $result);

        return view('refund.index', [
            'title' => '退款记录',
            'refunds' => $result,
        ]);
    }

    public function create(Request $request)
    {
        $orderProductId = $request->get('og_id', 0);
        if (!$orderProductId)
        {
            return $this->autoReturn("订单里无此产品");
        }

        try
        {
            $result = ProductOrder::getOrderProduct($orderProductId);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        return view('refund.form', [
            'title' => '申请退款',
            'entity' => $result,
        ]);
    }

    public function show(Request $request, $id)
    {
        return view('refund.show');
    }

    public function store(Request $request)
    {
        $orderId = $request->get('order_id', '');
        $orderProductId = intval($request->get('order_product_id', 0));
        $serviceType = $request->get('service_type', "");
        $reason = $request->get('reason', '');
        $description = $request->get('description');
        $images = $request->get('images');
        if ($images)
        {
            $images = json_decode(FctCommon::fctBase64Decode($images), true);
            if (!$images)
            {
                return $this->autoReturn("图片上传有误");
            }

            $images = implode(',', $images);
        }

        try
        {
            FctValidator::hasRequire($orderId, "订单号");
            FctValidator::hasRequire($orderProductId, "订单产品");
            FctValidator::hasRequire($reason, "申请原因");
            FctValidator::hasRequire($description, "申请描述");

            Refund::saveRefund($orderId, $orderProductId, $serviceType, $reason, $description, $images);

            return $this->returnAjaxSuccess("申请成功", url('settings/orders/' . $orderId));
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }
}
