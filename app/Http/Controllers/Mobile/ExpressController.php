<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-12-5
 * Time: 下午4:53
 */

namespace App\Http\Controllers\Mobile;


use App\Exceptions\BusinessException;
use App\Express;
use Illuminate\Http\Request;

class ExpressController extends BaseController
{

    public function index(Request $request)
    {
        $name = $request->get('name', '');
        $number = intval($request->get('number'));
        if ($name == '') {
            return $this->autoReturn('物流名称不能为空', 404);
        }
        if ($number < 1) {
            return $this->autoReturn('物流单号不能为空', 404);
        }

        try
        {
            $result = Express::getExpress($number, $name);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }

        if ($result) {
            $result->number = $number;
            $result->name = $name;
        } else {
            return $this->autoReturn('没有查到此物流单号', 404);
        }

        return view('express.index', [
            'title' => fct_title('订单物流信息'),
            'entity' => $result,
        ]);
    }
}