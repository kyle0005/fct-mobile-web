<?php

namespace App\Http\Controllers\Mobile;

use App\Exceptions\BusinessException;
use App\Recharge;
use Illuminate\Http\Request;

/**充值
 * Class RechargeController
 * @package App\Http\Controllers\Mobile
 */
class RechargeController extends BaseController
{
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        try
        {
            $result = Recharge::getRecharges($page);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess("成功", null, $result);

        return view('recharge.index', [
            'title' => '充值记录',
            'recharges' => $result,
        ]);
    }

    public function create(Request $request)
    {
        try
        {
            $result = Recharge::create();
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        return view('recharge.create', [
            'title' => '充值',
            'recharge' => $result,
        ]);
    }

    public function show(Request $request, $id)
    {
        try
        {
            $result = Recharge::getRecharge($id);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        return view('recharge.show', $result);
    }

    public function store(Request $request)
    {
        $payAmount = $request->get('charge_num', 0);

        try
        {
            $result = Recharge::saveRecharge($payAmount);
            if ($result < 1) {
                return $this->autoReturn('充值异常');
            }

            return $this->returnAjaxSuccess("订单创建成功",
                sprintf('%s?tradetype=buy&tradeid=%s', env('PAY_URL'), $result));
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }


}
