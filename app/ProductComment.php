<?php

namespace App;

use App\Exceptions\BusinessException;

/**用户购买评价
 * Class ProductComment
 * @package App
 */
class ProductComment
{
    public static function getComments($productId, $pageIndex = 1)
    {
        $pageSize = 20;
        $result = Base::http(
            env('API_URL') . sprintf('/products/%d/comments', $productId),
            [
                'page_index' => $pageIndex,
                'page_size' => $pageSize,
            ],
            [],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        $pagination = Base::pagination($result->data, $pageSize);

        return $pagination;
    }

    public static function saveComment($orderId, $productId, $content,
                                       $descScore, $expressScore, $saleScore, $picture)
    {
        $result = Base::http(
            env('API_URL') . sprintf('/products/%d/comments', $productId),
            [
                'order_id' => $orderId,
                'product_id' => $productId,
                'content' => $content,
                'desc_score' => $descScore,
                'express_score' => $expressScore,
                'sale_score' => $saleScore,
                'picture' => $picture,
                //评论字段
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return $result;
    }


}
