<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-6-22
 * Time: 上午11:07
 */

namespace App;


use App\Exceptions\BusinessException;

class FctValidator
{

    public static function hasRealName($name)
    {
        self::hasRequire($name, '姓名');
    }

    public static function hasIDCardNO($idCardNo)
    {
        self::hasRequire($idCardNo, '身份证号');

    }

    public static function hasBankInfo($bankName, $bankCardNo)
    {
        self::hasRequire($bankName, '银行名称');
        self::hasRequire($bankCardNo, '银行卡号');
        if (mb_strpos($bankName, "银行") === false)
        {
            throw new BusinessException('请输入正确的银行名称，如中国银行');
        }

    }

    /**验证是否为手机号码
     * @param $mobile
     * @return mixed
     * @throws BusinessException
     */
    public static function hasMobile($mobile)
    {
        $fieldName = '手机号码';
        self::hasRequire($mobile, $fieldName);
        self::hasLength($mobile, 11, $fieldName);

        return $mobile;
    }

    public static function hasPassword($password, $fieldName = '')
    {
        $fieldName = $fieldName ? $fieldName : '密码';
        self::hasRequire($password, $fieldName);
        self::hasLengthBetween($password, 6, 16, $fieldName);

        return $password;
    }

    public static function hasMobileCaptcha($captcha)
    {
        $fieldName = '手机验证码';
        self::hasRequire($captcha, $fieldName);
        self::hasLength($captcha, 6, $fieldName);

        return $captcha;
    }

    /**检查数字是否在某个区间
     * @param $number
     * @param $min
     * @param $max
     * @param string $message
     * @param string $fieldName
     * @return mixed
     * @throws BusinessException
     */
    public static function hasBetween($number, $min, $max, $message='', $fieldName = '')
    {
        if ($number < $min || $number > $max)
        {
            throw new BusinessException($message ? $message : ($fieldName . '数字必须在' . $min . '与' . $max . '之间'));
        }

        return $number;
    }

    /**检查字符长度是否在某个区间
     * @param $str
     * @param $min
     * @param $max
     * @param string $fieldName
     * @return mixed
     */
    public static function hasLengthBetween($str, $min, $max, $fieldName = '')
    {

        self::hasBetween(strlen($str), $min, $max, $fieldName . '长度必须在' . $min . '与' . $max . '之间');
        return $str;
    }

    /**字符长度是否等于多少
     * @param $str
     * @param $number
     * @param $fieldName
     * @return mixed
     * @throws BusinessException
     */
    public static function hasLength($str, $number, $fieldName)
    {
        if (strlen($str) != $number)
        {
            throw new BusinessException($fieldName . '长度必须为' . $number);
        }
        return $str;
    }

    /**是否为空
     * @param $str
     * @param $fieldName
     * @return mixed
     * @throws BusinessException
     */
    public static function hasRequire($str, $fieldName)
    {
        if (!$str)
        {
            throw new BusinessException('请输入' . $fieldName);
        }

        return $str;
    }

    public static function hasEqual($str1, $str2, $fieldName1, $fieldName2)
    {
        if ($str1 != $str2)
        {
            throw new BusinessException($fieldName1 . '与' . $fieldName2 . '不相同');
        }

        return $str1;
    }

    /**所有未知请求都定义为非法请求
     * @throws BusinessException
     */
    public static function illegalRequest()
    {
        throw new BusinessException('非法请求');
    }
}