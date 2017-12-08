<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-12-6
 * Time: 下午4:11
 */

namespace App\Http\Controllers\Mobile;


use App\AuctionBid;
use App\Exceptions\BusinessException;
use Illuminate\Http\Request;

class AuctionBidController extends BaseController
{
    public function store(Request $request) {

        $productId = intval($request->get('goods_id'));
        $price = floatval($request->get('price'));
        if ($productId < 1) {
            return $this->autoReturn('拍品ID不存在', 404);
        }

        try
        {
            $result = AuctionBid::saveBid($productId, $price);
            return $this->returnAjaxSuccess('出价成功', null, $result);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }
    }
}