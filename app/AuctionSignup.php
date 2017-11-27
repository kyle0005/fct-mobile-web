<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-11-27
 * Time: 下午2:53
 */

namespace App;


use App\Exceptions\BusinessException;

class AuctionSignup
{

    public static $resourceUrl = '/auction/signup';


    public static function getSignups($keywords, $status, $page)
    {
        $pageIndex = $page < 1 ? 1 : $page;
        $pageSize = 20;

        $result = Base::http(
            env('API_URL') . sprintf('%s/list', self::$resourceUrl),
            [
                'q' => $keywords,
                'status' => $status,
                'page_index' => $pageIndex,
                'page_size' => $pageSize,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        $pagination = Base::pagination($result->data, $pageIndex, $pageSize);

        return $pagination;
    }

    public static function saveSignup($productId)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/create', self::$resourceUrl),
            [
                'goods_id' => $productId,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return $result->data;
    }
}