<?php

namespace App\Http\Controllers\Mobile;

use App\Exceptions\BusinessException;
use App\ProductComment;
use Illuminate\Http\Request;

class ProductCommentController extends BaseController
{
    public function store(Request $request, $product_id)
    {
        $orderId = $request->get('order_id');
        $content = $request->get('content');
        $descScore = $request->get('desc_score');
        $expressScore = $request->get('express_score');
        $saleScore = $request->get('sale_score');
        $picture = $request->get('picture');

        try
        {
            $result = ProductComment::saveComment($orderId, $product_id, $content,
                $descScore, $expressScore, $saleScore, $picture);

            return $this->returnAjaxSuccess($result->message);

        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }
}
