<?php

namespace App;

use App\Exceptions\BusinessException;

class MemberAddress
{
    public static function getAddresses()
    {
        $result = Base::http(
            env('API_URL') . '/address',
            [],
            [],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return $result->data;
    }

    public static function getAddress($id)
    {
        $result = Base::http(
            env('API_URL') . sprintf('/address/%d', $id),
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

    public static function saveAddress($id, $name, $phone, $province, $city, $region, $address, $isDefault)
    {
        $result = Base::http(
            env('API_URL') . '/address',
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
            env('API_URL') . sprintf('/address/%d/default', $id),
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
            env('API_URL') . sprintf('/address/%d/delete', $id),
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
