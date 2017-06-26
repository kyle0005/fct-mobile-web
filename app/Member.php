<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-6-22
 * Time: 下午3:51
 */

namespace App;


class Member
{

    /**登录
     * @param $username
     * @param $password
     * @param $captcha
     * @param $sessionId
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public static function login($cellphone, $password, $captcha, $sessionId, $ip)
    {
        $result = Base::http(
            env('API_URL') . '/member/login',
            [
                'cellphone' => $cellphone,
                'password' => $password,
                'captcha' => $captcha,
                'session_id' => $sessionId,
                'ip' => $ip,
                'expire_day' => 86400,
            ]
        );
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
    public static function updateInfo($memberId, $username, $gender, $weixin)
    {
        $result = Base::http(
            env('API_URL') . '/member/update-info',
            [
                'member_id' => $memberId,
                'username' => $username,
                'gender' => $gender,
                'weixin' => $weixin,
            ]
        );
        return $result;
    }

    /**修改密码
     * @param $memberId
     * @param $password
     */
    public static function changePassowrd($memberId, $oldPassword, $newPassword)
    {
        $result = Base::http(
            env('API_URL') . '/member/change-password',
            [
                'member_id' => $memberId,
                'old_password' => $oldPassword,
                'new_password' => $newPassword,
            ]
        );
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
        return $result;
    }

    /**个人实名认证信息
     * @param $memberId
     * @param $realInfo 认证信息
     */
    public static function realAuth($memberId, $name, $idCardNo, $idCardImageUrl, $bankName, $bankAccount)
    {
        $result = Base::http(
            env('API_URL') . '/member/real-auth',
            [
                'member_id' => $memberId,
                'name' => $name,
                'idcard_no' => $idCardNo,
                'idcard_image_url' => $idCardImageUrl,
                'bank_name' => $bankName,
                'bank_account' => $bankAccount,
            ]
        );
        return $result;
    }

    /**退出
     * @param $memberId
     */
    public static function logout($memberId)
    {

    }
}