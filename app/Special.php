<?php
/**
 * Created by PhpStorm.
 * User: rokite
 * Date: 18-4-24
 * Time: 上午9:52
 */

namespace App;


use App\Exceptions\BusinessException;

class Special
{
    public static $resourceUrl = '/mall/special';

    public static function getHome()
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/home', self::$resourceUrl),
            [],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg, $result->code);
        }

        $entity = $result->data;
        //$entity->product = $entity->recommend;
        return $entity;
    }
}