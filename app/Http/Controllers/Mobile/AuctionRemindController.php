<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-12-4
 * Time: 下午4:26
 */

namespace App\Http\Controllers\Mobile;


use App\AuctionRemind;
use App\Exceptions\BusinessException;
use Illuminate\Http\Request;

class AuctionRemindController extends BaseController
{

    public function store(Request $request) {

        $productId = intval($request->get('goods_id'));
        if ($productId < 1) {
            return $this->autoReturn('拍品ID不存在', 404);
        }

        try
        {
            $result = AuctionRemind::saveRemind($productId);
            return $this->returnAjaxSuccess('提醒成功', null, $result);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }
    }

}