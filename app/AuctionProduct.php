<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-11-27
 * Time: 下午2:23
 */

namespace App;


use App\Exceptions\BusinessException;

class AuctionProduct
{

    public static $resourceUrl = '/auction/goods';


    public static function getProducts($name, $categoryId, $artistId, $status, $page)
    {
        $pageIndex = $page < 1 ? 1 : $page;
        $pageSize = 20;

        $result = Base::http(
            env('API_URL') . sprintf('%s/list', self::$resourceUrl),
            [
                'name' => $name,
                'cate_id' => $categoryId,
                'artist_id' => $artistId,
                'status' => $status,
                'page_index' => $pageIndex,
                'page_size' => $pageSize,
            ],
            [],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        $pagination = Base::pagination($result->data, $pageIndex, $pageSize);

        return $pagination;
    }

    public static function getProduct($id)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/detail/%d', self::$resourceUrl, $id),
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
}