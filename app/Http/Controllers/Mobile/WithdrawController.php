<?php

namespace App\Http\Controllers\Mobile;

use App\Exceptions\BusinessException;
use App\Withdraw;
use Illuminate\Http\Request;

class WithdrawController extends BaseController
{
    public function index(Request $request)
    {
        try
        {
            $result = Withdraw::getWithdraws();
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        return view('withdraw.index');
    }

    public function create(Request $request)
    {
/*        try
        {
            $result = Withdraw::getWithdraws();
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }*/


        return view('withdraw.create', [
            'title' => '申请提现',
            'withdraw' => (object) [],
        ]);
    }

    public function show(Request $request, $id)
    {
        return view('withdraw.show');
    }

    public function store(Request $request)
    {

    }
}
