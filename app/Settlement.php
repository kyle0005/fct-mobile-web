<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-14
 * Time: 下午1:26
 */

namespace App;


use App\Exceptions\BusinessException;

class Settlement
{
    public static $resourceUrl = '/finance/settlements';

    public static function getSettlements($status, $page = 1)
    {
        $pageIndex = $page < 1 ? 1 : $page;
        $pageSize = 20;

        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [
                'status' => $status ? 2 : 0,
                'page_index' => $pageIndex,
                'page_size' => $pageSize,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg, $result->code);
        }

        $pagination = Base::pagination($result->data, $pageIndex, $pageSize);
        return $pagination;
    }
}