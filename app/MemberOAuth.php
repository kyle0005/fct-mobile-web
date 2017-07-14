<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-12
 * Time: 下午5:34
 */

namespace App;


use App\Exceptions\BusinessException;

class MemberOAuth
{
    public static $resourceUrl = '/member/address';

    public static function getURL()
    {
        $callback = url('callback');

        $result = Base::http(
            env('API_URL') . sprintf('%s/oauth', self::$resourceUrl),
            [
                'callback_url' => $callback,
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

    public static function saveOAuth($code)
    {

        $result = Base::http(
            env('API_URL') . sprintf('%s/callback', self::$resourceUrl),
            [
                'code' => $code,
                'platform' => env('WEIXIN_PLATFORM'),
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        if ($result->data)
        {
            Member::setAuth($result->data);
        }

        return $result->data;
    }

    public static function bindOAuth($openid, $cellphone, $captcha, $sessionId, $ip)
    {
        $expireDay = 3;
        $result = Base::http(
            env('API_URL') . sprintf('%s/bind', self::$resourceUrl),
            [
                'openid' => $openid,
                'cellphone' => $cellphone,
                'platform' => env('WEIXIN_PLATFORM'),
                'captcha' => $captcha,
                'session_id' => $sessionId,
                'ip' => $ip,
                'expire_day' => $expireDay,
            ]
        );
        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        Member::setAuth($result->data, $expireDay);

        return $result->data;
    }
}