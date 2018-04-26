<?php
/**
 * Created by PhpStorm.
 * User: rokite
 * Date: 18-4-24
 * Time: 上午9:55
 */

namespace App;


use App\Exceptions\BusinessException;

class Search
{
    public static $resourceUrl = '/mall/search';

    public static function searchAll($keyword)
    {
        //默认无记录
        if (!$keyword) return [];

        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [
                'keyword' => $keyword,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg, $result->code);
        }

        return $result->data;
    }
}