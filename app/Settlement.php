<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-14
 * Time: 下午1:26
 */

namespace App;


class Settlement
{
    public static $resourceUrl = '/finance/settlements';

    public static function getSettlements($page = 1)
    {
        $pageIndex = $page < 1 ? 1 : $page;
        $pageSize = 20;

        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [
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

        return $result->data;
    }
}