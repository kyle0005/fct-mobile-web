<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-6-22
 * Time: 下午1:53
 */

namespace App;


use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Cache;

class Artist
{
    public static $resourceUrl = '/artists';

    public static function getArtists($pageIndex)
    {
        $cacheKey = 'artists_' . $pageIndex;
        $cacheTime = 30;
        $cacheResult = false;

        if (Cache::has($cacheKey))
        {
            $cacheResult = Cache::get($cacheKey);
        }

        if (!$cacheResult) {

            $pageSize = 20;
            $result = Base::http(
                env('API_URL') . self::$resourceUrl,
                [
                    'page_index' => $pageIndex,
                    'page_size' => $pageSize,
                ],
                [],
                'GET'
            );

            if ($result->code != 200) {
                throw new BusinessException($result->msg);
            }

            $pagination = Base::pagination($result->data, $pageIndex, $pageSize);

            $cacheResult = $pagination;
            Cache::put($cacheKey, $cacheResult, $cacheTime);
        }

        return $cacheResult;
    }

    public static function getArtist($id)
    {
        $cacheKey = 'artist_' . $id;
        $cacheTime = 3;
        $cacheResult = false;

        if (Cache::has($cacheKey))
        {
            $cacheResult = Cache::get($cacheKey);
        }

        if (!$cacheResult) {
            $pageSize = 20;
            $result = Base::http(
                env('API_URL') . sprintf('%s/%d', self::$resourceUrl, $id),
                [],
                [],
                'GET'
            );

            if ($result->code != 200) {
                throw new BusinessException($result->msg);
            }

            $artist = $result->data;
            $artist->dynamicList = Base::pagination($artist->dynamicList, 1, $pageSize);
            $cacheResult = $artist;
            Cache::put($cacheKey, $cacheResult, $cacheTime);
        }

        return $cacheResult;
    }

    public static function getArtistAndProducts($id, $productId = 0)
    {
        $cacheKey = 'artist_' . $id .'_products';
        $cacheTime = 30;
        $cacheResult = false;

        if (Cache::has($cacheKey))
        {
            $cacheResult = Cache::get($cacheKey);
        }

        if (!$cacheResult) {
            $result = Base::http(
                env('API_URL') . sprintf('%s/%d/products', self::$resourceUrl, $id),
                [],
                [],
                'GET'
            );

            if ($result->code != 200) {
                throw new BusinessException($result->msg);
            }

            $cacheResult = $result->data;
            Cache::put($cacheKey, $cacheResult, $cacheTime);
        }

        if ($cacheResult && $cacheResult->products) {
            $products = [];
            $temp = 0;
            foreach ($cacheResult->products as $product) {
                if ($product->id != $productId)
                {
                    $products[] = $product;
                    $temp++;
                }

                if ($temp == 3)
                    break;
            }

            $cacheResult->products = $products;
        }

        return $cacheResult;
    }

    public static function getArtistByIds($ids, $productId)
    {
        if (!$ids)
            throw new BusinessException('守艺人不存在');

        $idArr = explode(',', $ids);
        if (!$idArr)
            throw new BusinessException('守艺人不存在');

        $artists = [];
        foreach ($idArr as $value)
        {
            $artists[] = self::getArtistAndProducts($value, $productId);
        }

        return $artists;
    }

    public static function addVisitCount($id) {

        $limitVisitCacheName = 'a_v_' . $id;
        $longIp = ip2long(request()->ip());
        $visiters = [];
        if (Cache::has($limitVisitCacheName))
        {
            $visiters = Cache::get($limitVisitCacheName);
        }
        if (in_array($longIp, $visiters)) {

            return true;
        }
        //初次访问记录ip
        $visiters[] = $longIp;
        //获取当天过期时间变缓存
        $cacheTime = (strtotime(date('Y-m-d 23:59:59')) - time()) / 60;
        Cache::put($limitVisitCacheName, $visiters, $cacheTime);

        $result = Base::http(
            env('API_URL') . sprintf('%s/%d/visit', self::$resourceUrl, $id),
            [],
            [],
            'POST'
        );

        return true;
    }
}