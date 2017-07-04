<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-6-22
 * Time: 下午3:51
 */

namespace App;


use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class Member
{

    protected static $cookieKey = 'fct_auth';
    /**登录
     * @param $username
     * @param $password
     * @param $captcha
     * @param $sessionId
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public static function login($cellphone, $password, $captcha, $sessionId, $ip)
    {
        $expireDay = 3;
        $result = Base::http(
            env('API_URL') . '/member/login',
            [
                'cellphone' => $cellphone,
                'password' => $password,
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
        //缓存用户数据
        $expire = $expireDay * 1440;
        Cache::put($result->data->token, $result->data, $expire);
        Cookie::queue(self::$cookieKey, $result->data->token, $expire);

        return $result;
    }

    /**快捷登录
     * @param $username
     * @param $captcha
     */
    public static function register($username, $captcha)
    {

    }

    /**更新个人资料
     * @param $memberId
     * @param $username
     * @param $gender
     * @param $weixin
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public static function updateInfo($username, $gender, $weixin)
    {
        $result = Base::http(
            env('API_URL') . '/member/update-info',
            [
                'username' => $username,
                'gender' => $gender,
                'weixin' => $weixin,
            ],
            [env('MEMBER_TOKEN_NAME') => self::getToken()]
        );
        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }
        return $result;
    }

    /**修改密码
     * @param $memberId
     * @param $password
     */
    public static function changePassowrd($oldPassword, $newPassword)
    {
        $result = Base::http(
            env('API_URL') . '/member/change-password',
            [
                'old_password' => $oldPassword,
                'new_password' => $newPassword,
            ],
            [env('MEMBER_TOKEN_NAME') => self::getToken()]
        );
        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }
        return $result;
    }

    /**通过手机验证码找回密码
     * @param $username
     * @param $captcha
     * @param $password
     */
    public static function forgetPassword($cellphone, $captcha, $password, $sessionId)
    {
        $result = Base::http(
            env('API_URL') . '/member/forget-password',
            [
                'cellphone' => $cellphone,
                'password' => $password,
                'captcha' => $captcha,
                'session_id' => $sessionId,
            ]
        );
        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }
        return $result;
    }

    /**个人实名认证信息
     * @param $memberId
     * @param $realInfo 认证信息
     */
    public static function realAuth($name, $idCardNo, $idCardImageUrl, $bankName, $bankAccount)
    {
        $result = Base::http(
            env('API_URL') . '/member/real-auth',
            [
                'name' => $name,
                'idcard_no' => $idCardNo,
                'idcard_image_url' => $idCardImageUrl,
                'bank_name' => $bankName,
                'bank_account' => $bankAccount,
            ],
            [env('MEMBER_TOKEN_NAME') => self::getToken()]
        );
        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }
        return $result;
    }

    public static function getMemberByToken($token = '')
    {
        $token = $token ? $token : self::getToken();
        $result = Base::http(
            env('API_URL') . '/member/get-by-token',
            [],
            [env('MEMBER_TOKEN_NAME') => $token],
            'GET'
        );
        if ($result->code == 200)
            return $result->data;
        return false;
    }

    public static function getToken()
    {
        return Cookie::has(self::$cookieKey) ? Cookie::get(self::$cookieKey) : "";
    }

    public static function getAuth()
    {
        $member = false;
        $token = self::getToken();
        if ($token)
        {
            $member = Cache::has($token) && Cache::get($token) ? Cache::get($token) : false;
            if (!$member)
            {
                $member = self::getMemberByToken($token);
                if ($member)
                {
                    $expire = intval((intval($member->expireTime / 1000) - time()) / 60);
                    Cache::put($token, $member, $expire);
                }
            }
        }

        return $member;
    }

    /**退出
     * @param $memberId
     */
    public static function logout($memberId)
    {

    }
}