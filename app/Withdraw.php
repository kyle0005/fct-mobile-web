<?php

namespace App;


use App\Exceptions\BusinessException;

class Withdraw
{
    public static $resourceUrl = '/finance/withdraws';

    public static function getWithdraws($status, $page = 1)
    {
        $pageIndex = $page < 1 ? 1 : $page;
        $pageSize = 20;

        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [
                'status' => $status,
                'page_index' => $pageIndex,
                'page_size' => $pageSize,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        $pagination = Base::pagination($result->data, $pageSize);

        return $pagination;
    }

    public static function getWithdraw($id)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/%d', self::$resourceUrl, $id),
            [],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return $result->data;
    }

    public static function saveWithdraw($amount)
    {
        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [
                'amount' => $amount,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return $result->data;
    }

    public static function create()
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/create', self::$resourceUrl),
            [],
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
