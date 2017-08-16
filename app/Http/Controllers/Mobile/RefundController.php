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
            'title' => fct_title('售后记录'),
            'refunds' => $result,
        ]);
    }

    public function create(Request $request)
    {
        $orderProductId = $request->get('og_id', 0);
        if (!$orderProductId)
        {
            return $this->autoReturn("订单里无此宝贝");
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
            'title' => fct_title('申请售后'),
            'entity' => $result,
        ]);
    }

    public function show(Request $request, $id)
    {

        try
        {
            $result = Refund::getRefund($id);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        return view('refund.show', [
            'title' => fct_title('售后详情'),
            'entity' => $result,
        ]);
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
            $images = json_decode($images, true);
            if (!$images)
            {
                return $this->autoReturn("图片上传有误");
            }

            $images = implode(',', $images);
        }

        try
        {
            FctValidator::hasRequire($orderId, "订单号");
            FctValidator::hasRequire($orderProductId, "订单宝贝");
            FctValidator::hasRequire($reason, "申请原因");
            FctValidator::hasRequire($description, "申请描述");

            Refund::saveRefund($orderId, $orderProductId, $serviceType, $reason, $description, $images);

            return $this->returnAjaxSuccess("申请成功", url('my/refunds'));
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }

    public function setCancel(Request $request, $id)
    {
        if ($id < 1)
        {
            return $this->autoReturn('记录不存在');
        }
        try
        {
            Refund::cancel($id);
            return $this->returnAjaxSuccess('取消成功', url('my/refunds/' . $id));
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }
}
