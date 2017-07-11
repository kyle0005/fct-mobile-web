<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-6-22
 * Time: 上午11:28
 */

namespace App;


use Illuminate\Support\Facades\Cookie;
use Ramsey\Uuid\Uuid;

class FctCommon
{
    /**去除所有空格
     * @param $str
     * @return mixed
     */
    public static function trimAll($str)
    {
        return str_replace(
            [" ","　","\t","\n","\r"],
            ["","","","",""],
            $str);
    }

    public static function secondToString($time, $i = 2)
    {
        $dateArr = [];
        $dateSpec = [86400 => '天', 3600 => '小时', 60 => '分钟'];
        foreach ($dateSpec as $key => $value) {

            if ($time >= $key) {
                $count = intval($time / $key);
                $time = $time % $key;
                $dateArr[] = $count . $value;
                if (count($dateArr) == $i || !$time) {

                    break;
                }
            }
        }
        return $dateArr ? implode("", $dateArr) : "";

    }

    /**生成验证码验证的SESSION_ID
     * @return string
     */
    public static function createMobileSessionId()
    {
        $uuid = Uuid::uuid1()->getHex();
        Cookie::queue('_mvsid', $uuid, 10);
        return $uuid;
    }

    /**获取验证码SESSION_ID
     * @return string
     */
    public static function getMobileSessionId()
    {
        return Cookie::has('_mvsid') ? Cookie::get('_mvsid') : '';
    }

    /**删除验证码SESSION_ID
     *
     */
    public static function removeMobileSessionId()
    {
        Cookie::forget('_mvsid');
    }

    public static function fctBase64Encode($str)
    {
        if (!$str)
            return $str;

        return str_replace(['+', '/', '='], ['-', '_', '*'], base64_encode($str));
    }

    public static function fctBase64Decode($base64Str)
    {
        if (!$base64Str)
            return $base64Str;

        return base64_decode(str_replace(['-', '_', '*'], ['+', '/', '='], $base64Str));
    }

}