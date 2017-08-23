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
                env('API_URL') . '/artists',
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

            $pagination = Base::pagination($result->data, $pageSize);

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
                env('API_URL') . sprintf('/artists/%d', $id),
                [],
                [],
                'GET'
            );

            if ($result->code != 200) {
                throw new BusinessException($result->msg);
            }

            $artist = $result->data;
            $artist->dynamicList = Base::pagination($artist->dynamicList, $pageSize);
            $cacheResult = $artist;
            Cache::put($cacheKey, $cacheResult, $cacheTime);
        }

        return $cacheResult;
    }

    public static function getArtistsByProductId($productId)
    {
        $cacheKey = 'artists_by_product_' . $productId;
        $cacheTime = 10;
        $cacheResult = false;

        if (Cache::has($cacheKey))
        {
            $cacheResult = Cache::get($cacheKey);
        }

        if (!$cacheResult) {
            $result = Base::http(
                env('API_URL') . '/artists/by-product',
                [
                    'product_id' => $productId,
                ],
                [],
                'GET'
            );

            if ($result->code != 200) {
                throw new BusinessException($result->msg);
            }

            $cacheResult = $result->data;

            Cache::put($cacheKey, $cacheResult, $cacheTime);
        }

        return $cacheResult;
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
            env('API_URL') . sprintf('/artists/%d/visit', $id),
            [],
            [],
            'POST'
        );
/*
        if ($result->code != 200) {
            throw new BusinessException($result->msg);
        }*/

        return true;
    }
}