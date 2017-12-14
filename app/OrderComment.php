<?php

namespace App;

use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Cache;

/**用户购买评价
 * Class ProductComment
 * @package App
 */
class OrderComment
{
    public static $resourceUrl = '/mall/order/comments';

    public static function getComments($productId, $pageIndex = 1)
    {
        $cacheKey = 'product_'.$productId.'_comments_' . $pageIndex;
        $cacheTime = 30;
        $cacheResult = false;

        if (Cache::has($cacheKey)) {
            $cacheResult = Cache::get($cacheKey);
        }

        if (!$cacheResult) {
            $pageSize = 20;
            $result = Base::http(
                env('API_URL') . self::$resourceUrl,
                [
                    'product_id' => $productId,
                    'page_index' => $pageIndex,
                    'page_size' => $pageSize,
                ],
                [],
                'GET'
            );

            if ($result->code != 200) {
                throw new BusinessException($result->msg, $result->code);
            }

            $pagination = Base::pagination($result->data, $pageIndex, $pageSize);

            $cacheResult = $pagination;
            Cache::put($cacheKey, $cacheResult, $cacheTime);
        }

        return $cacheResult;
    }

    //(String order_id, Integer express_score, Integer has_anonymous, Integer sale_score, String productInfo
    //[{goodsId:1, descScore:5, content:xxx, picture:xxxx},...]
    public static function saveComment($orderId, $expressScore, $hasAnonymous, $saleScore, $productInfo)
    {
        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [
                'order_id' => $orderId,
                'express_score' => $expressScore,
                'has_anonymous' => $hasAnonymous ? 1 : 0,
                'sale_score' => $saleScore,
                'product_info' => $productInfo,
                //评论字段
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg, $result->code);
        }

        return true;
    }


}
