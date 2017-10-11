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
        $status = intval($request->get('status', 0));
        try
        {
            $result = Withdraw::getWithdraws($status, $page);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess("成功", null, $result);

        return view('withdraw.index', [
            'title' => fct_title('提现记录'),
            'withdraws' => $result,
        ]);
    }

    public function store(Request $request)
    {
        $amount = floatval($request->get('amount', 0));

        try
        {
            Withdraw::saveWithdraw($amount);
            return $this->returnAjaxSuccess('提交成功', url('my/account/withdraw', [], env('APP_SECURE')));
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
            $url = null;
            if ($e->getCode() == 401)
                $url = url('my/account', [], env('APP_SECURE'));
            elseif ($e->getCode() == 402)
                $url = url('my/account/real-auth', [], env('APP_SECURE'));

            return $this->autoReturn($e->getMessage(), $url);
        }


        return view('withdraw.create', [
            'title' => fct_title('申请提现'),
            'entry' => $result,
        ]);
    }

    public function show(Request $request, $id)
    {
        return view('withdraw.show');
    }
}
