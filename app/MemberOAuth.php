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
    public static $resourceUrl = '/member/oauth';

    public static function getURL()
    {
        $callback = url('oauth/callback', [], env('APP_SECURE'));

        $result = Base::http(
            env('API_URL') . sprintf('%s', self::$resourceUrl),
            [
                'callback_url' => $callback,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg, $result->code);
        }
        if(!$result->data)
        {
            throw new BusinessException('URL地址错误');
        }

        return $result->data;
    }

    public static function saveOAuth($code, $ip)
    {
        $expireDay = 3;

        $result = Base::http(
            env('API_URL') . sprintf('%s/callback', self::$resourceUrl),
            [
                'code' => $code,
                'platform' => env('WEIXIN_PLATFORM'),
                'ip' => $ip,
                'expire_day' => $expireDay,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg, $result->code);
        }

        $member = $result->data;

        //有过期的帐户，请空
        if (Member::getToken()) Member::cleanAuth();
        //自动登录
        if ($member && $member->memberId > 0) Member::setAuth($member);

        return $member;
    }

    public static function bindOAuth($inviterId, $openid, $cellphone, $captcha, $sessionId, $ip)
    {
        $expireDay = 3;
        $result = Base::http(
            env('API_URL') . sprintf('%s/bind', self::$resourceUrl),
            [
                'inviter_id' => $inviterId,
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
            throw new BusinessException($result->msg, $result->code);
        }

        Member::setAuth($result->data, $expireDay);

        return $result->data;
    }
}