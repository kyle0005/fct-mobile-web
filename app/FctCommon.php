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

}