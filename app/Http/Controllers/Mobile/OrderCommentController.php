<?php

namespace App\Http\Controllers\Mobile;

use App\Exceptions\BusinessException;
use App\FctCommon;
use App\FctValidator;
use App\OrderComment;
use App\ProductOrder;
use Illuminate\Http\Request;

class OrderCommentController extends BaseController
{

    public function create(Request $request, $order_id)
    {
        try
        {
            $result = ProductOrder::getOrder($order_id);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }

        return view('order-comment.form', [
            'title' => fct_title('购买评价'),
            'entity' => $result,
        ]);
    }

    public function store(Request $request, $order_id)
    {
        $hasAnonymous = $request->get('has_anonymous', 0);
        $expressScore = $request->get('express_score');
        $saleScore = $request->get('sale_score');
        $productInfo = $request->get('products', '');
        if (!$productInfo)
        {
            return $this->autoReturn("评价的宝贝不存在");
        }
        /*$productInfo = FctCommon::fctBase64Decode($productInfo);
        if (!$productInfo)
        {
            return $this->autoReturn("评价的宝贝不存在");
        }*/

        try
        {
            FctValidator::hasBetween($saleScore, 1, 5, "", "服务态度星级");
            FctValidator::hasBetween($expressScore, 1, 5, "", "物流服务星级");

            $jsonProducts = json_decode($productInfo);
            if (!$jsonProducts)
            {
                return $this->autoReturn("评价的宝贝不存在");
            }

            foreach ($jsonProducts as $key=>$product)
            {
                if ($product->goodsId < 1)
                {
                    return $this->autoReturn("评价的宝贝不存在");
                }
                FctValidator::hasBetween($product->descScore, 1, 5, "", "评论描述星级");
                FctValidator::hasRequire($product->content, '评论内容');
                $product->picture = $product->picture ? implode(',', $product->picture) : "";

                $jsonProducts[$key] = $product;
            }

            $productInfo = json_encode($jsonProducts, JSON_UNESCAPED_UNICODE);

            $result = OrderComment::saveComment($order_id, $expressScore, $hasAnonymous, $saleScore, $productInfo);

            $url = url('my/orders', [], env('APP_SECURE'));
            if (strpos($request->server('HTTP_REFERER'), '/orders/') !== false) {
                $url .= '/'. $order_id;
            }
            return $this->returnAjaxSuccess("评论成功", $url);

        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage());
        }
    }
}
