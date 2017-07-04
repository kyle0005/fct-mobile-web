<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-6-22
 * Time: 下午1:53
 */

namespace App;


use App\Exceptions\BusinessException;

class Artist
{

    public static function getRows($pageIndex)
    {
        $pageSize = 20;
        $result = Base::http(
            env('API_URL') . '/artists',
            [
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

        $pagination = Base::pagination($result->data, $pageSize);

        return $pagination;
    }

    public static function getRow($id)
    {
        $result = Base::http(
            env('API_URL') . sprintf('/artists/%d', $id),
            [],
            [],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        $artist = $result->data;

        return [
            'title' => (isset($artist->name) && $artist->name ? $artist->name : '艺术家详情') . '方寸堂',
            'artist' => json_encode($artist, JSON_UNESCAPED_UNICODE),
        ];
    }

    public static function getRowsByProductId($productId)
    {
        $result = Base::http(
            env('API_URL') . '/artists/by-product',
            [
                'product_id' => $productId,
            ],
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