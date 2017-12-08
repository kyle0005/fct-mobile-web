<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-12-5
 * Time: 下午4:52
 */

namespace App;


use App\Exceptions\BusinessException;

class Express
{
    public static $resourceUrl = '/express';

    /**获取订单物流信息
     * @param $number
     * @param $name
     * @return mixed
     * @throws BusinessException
     */
    public static function getExpress($number, $name)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/%d', self::$resourceUrl, $number),
            [
                'name' => $name,
                'number' => $number,
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
}