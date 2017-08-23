<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-6-22
 * Time: 下午3:39
 */

namespace App;


use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Cache;

class Product
{
    public static $resourceUrl = '/mall/products';

    /**宝贝详情
     * @param $id
     * @return array
     * @throws BusinessException
     */
    public static function getProduct($id)
    {
        $id = intval($id);
        if (!$id) {
            throw new BusinessException("无此宝贝");
        }


        $cacheKey = 'product_' . $id;
        $cacheTime = 5 / 60;
        $cacheResult = false;

        if (Cache::has($cacheKey)) {
            $cacheResult = Cache::get($cacheKey);
        }

        if (!$cacheResult) {
            $result = Base::http(
                env('API_URL') . sprintf('%s/%d', self::$resourceUrl, $id),
                [],
                [env('MEMBER_TOKEN_NAME') => Member::getToken()],
                'GET'
            );

            if ($result->code != 200) {
                throw new BusinessException($result->msg);
            }

            $product = $result->data;
            if ($product && $product->discount && isset($product->discount->discountTime)) {
                $product->discount->discountTime = FctCommon::secondToString($product->discount->discountTime);
            }
            if ($product->hasCoupon) {
                $product->coupon_url = url('coupons/new?product_id=' . $product->id);
            }

            $materialNames = '';
            $materials = ProductMaterial::getMaterialsByIds($product->materialId, $product->id);
            if ($materials)
            {
                foreach ($materials as $material) {

                    $materialNames .= ($materialNames ? '、' : '') . $material->name;
                }
            }

            $artistNames = '';
            $artists = Artist::getArtistsByProductId($product->id);
            if ($materials)
            {
                foreach ($artists as $artist) {

                    $artistNames .= ($artistNames ? '、' : '') . $artist->name;
                }
            }

            $product->artistNames = $artistNames;
            $product->materialNames = $materialNames;

            $cacheResult = $product;
            Cache::put($cacheKey, $cacheResult, $cacheTime);
        }

        return $cacheResult;
    }

    /**艺术家作品列表
     * @param $artistId
     * @return mixed
     * @throws BusinessException
     */
    public static function getPrdocutsByArtistId($artistId)
    {
        $result = Base::http(
            env('API_URL') . sprintf('%s/by-artist', self::$resourceUrl),
            [
                'artist_id' => $artistId,
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

    /**获取分享的宝贝
     * @param $categoryCode
     * @param $name
     * @param $page
     * @return mixed
     * @throws BusinessException
     */
    public static function getShareProducts($categoryCode, $name, $sortIndex, $page)
    {
        $pageIndex = $page < 1 ? 1 : $page;
        $pageSize = 20;

        $result = Base::http(
            env('API_URL') . sprintf('%s/share', self::$resourceUrl),
            [
                'name' => urlencode($name),
                'code' => $categoryCode,
                'sort_index' => $sortIndex,
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

    public static function addVisitCount($id) {

        $limitVisitCacheName = 'p_v_' . $id;
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
/*
        if ($result->code != 200) {
            throw new BusinessException($result->msg);
        }*/

        return true;
    }
}