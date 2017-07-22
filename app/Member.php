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

    /**登录
     * @param $cellphone
     * @param $password
     * @param $captcha
     * @param $sessionId
     * @param $ip
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     * @throws BusinessException
     */
    public static function login($cellphone, $password, $captcha, $sessionId, $ip)
    {
        $expireDay = 3;
        $result = Base::http(
            env('API_URL') . '/member/login',
            [
                'cellphone' => $cellphone,
                'password' => $password,
                'platform' => env('WEB_PLATFORM'),
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

        self::setAuth($result->data, $expireDay);

        return $result;
    }

    /**更新个人资料
     * @param $username
     * @param $avatar
     * @param $gender
     * @param $birthday
     * @param $weixin
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     * @throws BusinessException
     */
    public static function updateInfo($username, $avatar, $gender, $birthday, $weixin)
    {
        $result = Base::http(
            env('API_URL') . '/member/update-info',
            [
                'username' => $username,
                'avatar' => $avatar,
                'gender' => $gender,
                'birthday' => $birthday,
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
     * @param $oldPassword
     * @param $newPassword
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     * @throws BusinessException
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
     * @param $cellphone
     * @param $captcha
     * @param $password
     * @param $sessionId
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     * @throws BusinessException
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
     * @param $name
     * @param $idCardNo
     * @param $idCardImageUrl
     * @param $bankName
     * @param $bankAccount
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     * @throws BusinessException
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

    /**用户详情情
     *
     */
    public static function getMemberInfo()
    {
        $result = Base::http(
            env('API_URL') . '/member/info',
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

    /**根据token获取用户登录信息
     * @param string $token
     * @return mixed
     * @throws BusinessException
     */
    public static function getMemberByToken($token = '')
    {
        $token = $token ? $token : self::getToken();
        $result = Base::http(
            env('API_URL') . '/member/get-by-token',
            [],
            [env('MEMBER_TOKEN_NAME') => $token],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }
        return $result->data;
    }

    public static function getToken()
    {
        $result = Cookie::has(env('MEMBER_COOKIE_NAME')) ? Cookie::get(env('MEMBER_COOKIE_NAME')) : "";
        if ($result)
        {
            $aes = new FctCryptAES();
            $aes->set_key(env('MEMBER_COOKIE_MCRYPT_KEY'));
            $aes->require_pkcs5();
            $result = $aes->decrypt($result);
        }

        return $result;
    }

    public static function setAuth($member, $expireDay = 3)
    {
        //缓存用户数据
        $expire = $expireDay * 1440;
        Cache::put($member->token, $member, $expire);

        $aes = new FctCryptAES();
        $aes->set_key(env('MEMBER_COOKIE_MCRYPT_KEY'));
        $aes->require_pkcs5();
        $encText = $aes->encrypt($member->token);

        Cookie::queue(env('MEMBER_COOKIE_NAME'), $encText, $expire);
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