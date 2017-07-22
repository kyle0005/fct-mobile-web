<?php

namespace App\Http\Controllers\Mobile;

use App\Exceptions\BusinessException;
use App\Settlement;
use Illuminate\Http\Request;

class SettlementController extends BaseController
{
    public function index(Request $request)
    {
        try
        {
            $result = Settlement::getSettlements();
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        return view('settlement.index', [
            'title' => '佣金结算',
            'entries' => $result->entries,
            'pager' => $result->pager,
        ]);
    }
}
