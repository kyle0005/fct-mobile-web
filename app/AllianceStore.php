<?php
/**
 * Created by PhpStorm.
 * User: rokite
 * Date: 18-4-24
 * Time: 上午10:14
 */

namespace App;


use App\Exceptions\BusinessException;

class AllianceStore
{
    public static $resourceUrl = '/member/alliance/store';

    public static function find()
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

        return $result;
    }
}