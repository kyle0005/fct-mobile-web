<?php

namespace App;

use App\Exceptions\BusinessException;

class MemberAddress
{
    public static $resourceUrl = '/member/address';

    public static function getAddresses()
    {
        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return [
            'title' => '收货地址管理',
            'addressList' => $result->data,
        ];
    }

    public static function getAddress($id)
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

        return [
            'title' => '修改地址',
            'address' => $result->data,
        ];
    }

    public static function saveAddress($id, $name, $phone, $province, $city, $region, $address, $isDefault)
    {
        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [
                'id' => $id,
                'name' => $name,
                'phone' => $phone,
                'province' => $province,
                'city' => $city,
                'region' => $region,
                'address' => $address,
                'is_default' => $isDefault
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return true;
    }

    public static function setDefault($id)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/%d/default', self::$resourceUrl, $id),
            [
                'id' => $id,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return true;
    }

    public static function setDelete($id)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/%d/delete', self::$resourceUrl, $id),
            [
                'id' => $id,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return true;
    }
}
