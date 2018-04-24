<?php
/**
 * Created by PhpStorm.
 * User: rokite
 * Date: 18-4-24
 * Time: 上午10:12
 */

namespace App;


use App\Exceptions\BusinessException;

class AllianceKPI
{
    public static $resourceUrl = '/member/alliance/kpi';

    public static function find($page)
    {
        $pageIndex = $page < 1 ? 1 : $page;
        $pageSize = 20;

        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [
                'page_index' => $pageIndex,
                'page_size' => $pageSize,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg, $result->code);
        }

        $pagination = Base::pagination($result->data, $pageIndex, $pageSize);

        return $pagination;
    }
}