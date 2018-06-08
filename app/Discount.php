<?php

namespace App;

use App\Exceptions\BusinessException;

class Discount
{
    public static $resourceUrl = '/promotion/discount';

    public static function getDiscount($id)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/%d', self::$resourceUrl, $id),
            [],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg, $result->code);
        }

        if ($result->data) {
            foreach ($result->data as $key => $val) {
                $val->discountPrice = show_price($val->discountPrice);
                $val->salePrice = show_price($val->salePrice);
                $result->data[$key] = $val;
            }
        }

        return $result->data;
    }
}
