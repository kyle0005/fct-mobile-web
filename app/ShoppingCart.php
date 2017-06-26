<?php

namespace App;


class ShoppingCart
{
    /**购物车列表
     *
     */
    public static function index($memberId)
    {

    }

    /**增加（添加）购物车产品数量
     * @param $productId
     * @param $extendId
     * @param $number
     */
    public static function add($memberId, $productId, $extendId, $number)
    {

    }

    /**减少购物车中产品数量
     * @param $productId
     * @param $extendId
     * @param $number
     */
    public static function sub($memberId, $productId, $extendId, $number)
    {

    }

    /**从购物车中删除产品
     * @param $productId
     * @param $extendId
     */
    public static function remove($memberId, $productId, $extendId)
    {

    }

    public static function clear($memberId)
    {

    }
}
