<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-22
 * Time: 下午3:29
 */

namespace App;


use App\Exceptions\BusinessException;

class MemberAccount
{
    public static $resourceUrl = '/finance/member/account';

    public static function getLogs($pageIndex = 1)
    {
        $pageSize = 20;
        $result = Base::http(
            env('API_URL') . sprintf('%s/logs', self::$resourceUrl),
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

        $pagination = Base::pagination($result->data, $pageSize);

        return $pagination;
    }

    public static function getAccount()
    {
        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [],
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