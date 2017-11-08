<?php

namespace App\Http\Controllers\Mobile;

use App\Exceptions\BusinessException;
use App\Settlement;
use Illuminate\Http\Request;

class SettlementController extends BaseController
{
    public function index(Request $request)
    {
        $status = intval($request->get('status', 0)) ? 2 : 0;
        $page = $request->get('page', 1);
        try
        {
            $result = Settlement::getSettlements($status, $page);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        if ($request->ajax())
            return $this->returnAjaxSuccess("成功", null, $result);

        return view('settlement.index', [
            'title' => fct_title('佣金结算'),
            'status' => $status,
            'settlements' => $result,
        ]);
    }
}
