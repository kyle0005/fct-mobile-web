<?php
/**
 * Created by PhpStorm.
 * User: rokite
 * Date: 18-4-24
 * Time: 上午9:55
 */

namespace App;


use App\Exceptions\BusinessException;

class Search
{
    public static $resourceUrl = '/mall/search';

    public static function searchAll($keyword)
    {
        //默认无记录
        if (!$keyword) return [];

        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [
                'keyword' => $keyword,
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

    public static function searchProducts(
        $keyword, $category_id, $artist_id, $volume_min,
        $volume_max, $price_min, $price_max, $sort,
        $page_index, $is_search_filter
    ) {
        $page_index = $page_index > 1 ? $page_index : 1;
        $pageSize = 10;
        
        $result = Base::http(
            env('API_URL') . sprintf('%s/product', self::$resourceUrl),
            [
                "keyword" => $keyword,
                "category_id" => $category_id,
                "artist_id" => $artist_id,
                "volume_min" => $volume_min,
                "volume_max" => $volume_max,
                "price_min" => $price_min,
                "price_max" => $price_max,
                "sort" => $sort,
                "page_index" => $page_index,
                "page_size" => $pageSize,
                "is_search_filter" => $is_search_filter,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg, $result->code);
        }
        $newResult = (object) ["search" => null, "products" => null];
        if ($is_search_filter) {
            $newResult->search = (object) [
                "keywrod" => $keyword,
                "sorts" => $result->data->sorts,
                "artists" => $result->data->artists,
                "priceSorts" => $result->data->priceSorts,
                "volumes" => $result->data->volumes,
                "categorys" => ProductCategory::getCategories(),
                "products" => null,
            ];
        }
        $newResult->products = Base::pagination($result->data->products, $page_index, $pageSize);

        return $newResult;
    }
}