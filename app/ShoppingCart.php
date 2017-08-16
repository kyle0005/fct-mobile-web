<?php

namespace App;


use App\Exceptions\BusinessException;

class ShoppingCart
{
    public static $resourceUrl = '/mall/carts';

    /**购物车列表
     * @return bool|mixed|object|\Psr\Http\Message\ResponseInterface
     */
    public static function getShoppingCarts()
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
            'title' => fct_title('购物车'),
            'carts' => json_encode($result->data->cartList, JSON_UNESCAPED_UNICODE),
            'likes' => json_encode($result->data->likeList, JSON_UNESCAPED_UNICODE),
        ];
    }

    /**增加（添加）或减少购物车宝贝数量
     * @param $productId
     * @param $extendId
     * @param $number
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     * @throws BusinessException
     */
    public static function saveShoppingCart($productId, $extendId, $number)
    {
        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [
                'product_id' => $productId,
                'spec_id' => $extendId,
                'buy_number' => $number,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return $result;
    }

    /**从购物车中删除宝贝
     * @param $id
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     * @throws BusinessException
     */
    public static function remove($id)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/%d/delete', self::$resourceUrl, $id),
            [],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return $result;
    }

    /**清空购物车（底层没创建）
     * @return mixed|object|\Psr\Http\Message\ResponseInterface
     * @throws BusinessException
     */
    public static function clean()
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/clean', self::$resourceUrl),
            [],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return $result;
    }
}
