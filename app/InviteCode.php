<?php
/**
 * Created by PhpStorm.
 * User: rokite
 * Date: 18-4-25
 * Time: 下午2:10
 */

namespace App;


use App\Exceptions\BusinessException;

class InviteCode
{
    public static $resourceUrl = '/member/invite-code';
    public static function save()
    {
        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg, $result->code);
        }

        return $result->data;
    }

}