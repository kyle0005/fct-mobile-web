<?php

namespace App\Http\Controllers\Mobile;

use App\Exceptions\BusinessException;
use App\Withdraw;
use Illuminate\Http\Request;

class WithdrawController extends BaseController
{
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        try
        {
            $result = Withdraw::getWithdraws($page);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess("成功", null, $result);

        return view('withdraw.index', [
            'title' => '提现记录',
            'withdraws' => $result,
        ]);
    }

    public function store(Request $request)
    {
        $amount = floatval($request->get('amount', 0));

        try
        {
            Withdraw::saveWithdraw($amount);
            return $this->returnAjaxSuccess('提交成功', url('settings/account/withdraw'));
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }

    public function create(Request $request)
    {
        try
        {
            $result = Withdraw::create();
            //var_dump($result);die;
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }


        return view('withdraw.create', [
            'title' => '申请提现',
            'entry' => $result,
        ]);
    }

    public function show(Request $request, $id)
    {
        return view('withdraw.show');
    }
}
