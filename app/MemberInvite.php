<?php
/**
 * Created by PhpStorm.
 * User: rokite
 * Date: 18-5-10
 * Time: 下午4:21
 */

namespace App;


use App\Exceptions\BusinessException;

class MemberInvite
{
    public static $resourceUrl = '/member/invite';

    public static function findInvite()
    {
        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg, $result->code);
        }

        return $result->data;
    }

    public static function getTop()
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/top', self::$resourceUrl),
            [],
            [],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg, $result->code);
        }

        return $result->data;
    }
}