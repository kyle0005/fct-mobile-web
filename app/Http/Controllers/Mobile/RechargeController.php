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
        try
        {
            $result = Recharge::getRecharges();
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        return view('recharge.index', $result);
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

        return view('recharge.create', $result);
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
        $payAmount = $request->get('pay_amount', 0);
        $giftAmount = $request->get('gift_amount', 0);

        try
        {
            $result = Recharge::saveRecharge($payAmount, $giftAmount);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }


}
