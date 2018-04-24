<?php
/**
 * Created by PhpStorm.
 * User: rokite
 * Date: 18-4-24
 * Time: 上午10:10
 */

namespace App;


use App\Exceptions\BusinessException;

class Alliance
{
    public static $resourceUrl = '/member/alliance';

    public static function getAlliance()
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s', self::$resourceUrl),
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
}