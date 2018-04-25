<?php
/**
 * Created by PhpStorm.
 * User: rokite
 * Date: 18-4-25
 * Time: 下午2:11
 */

namespace App\Http\Controllers\Mobile;


use App\Exceptions\BusinessException;
use App\InviteCode;
use Illuminate\Http\Request;

class InviteCodeController extends BaseController
{

    public function store(Request $request)
    {

        try
        {
            $result = InviteCode::save();

            return $this->returnAjaxSuccess("申请成功", null, $result);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }
    }
}