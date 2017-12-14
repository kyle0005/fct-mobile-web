<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-11-27
 * Time: 下午2:40
 */

namespace App;


use App\Exceptions\BusinessException;

class AuctionOrder
{

    public static $resourceUrl = '/auction/order';


    public static function getOrders($keywords, $status, $page, $from='')
    {
        $pageIndex = $page < 1 ? 1 : $page;
        $pageSize = 20;

        $result = Base::http(
            env('API_URL') . sprintf('%s/list', self::$resourceUrl),
            [
                'q' => $keywords,
                'status' => $status,
                'from' => $from,
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

    public static function getOrder($orderId, $from)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/detail', self::$resourceUrl),
            [
                'order_id' => $orderId,
                'from' => $from,
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

    public static function createOrder($signupId)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/create', self::$resourceUrl),
            [
                'signup_id' => $signupId,
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

    public static function saveOrder($signupId, $addressId, $accountAmount, $points, $remark)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/submit', self::$resourceUrl),
            [
                'signup_id' => $signupId,
                'address_id' => $addressId,
                'account_amount' => $accountAmount,
                'points' => $points,
                'remark' => $remark,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg, $result->code);
        }

        return $result->data;
    }
}