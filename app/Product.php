<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-6-22
 * Time: 下午3:39
 */

namespace App;


use App\Exceptions\BusinessException;

class Product
{
    public static $resourceUrl = '/mall/products';

    /**产品详情
     * @param $id
     * @return array
     * @throws BusinessException
     */
    public static function getProduct($id)
    {
        $id = intval($id);
        if (!$id)
        {
            throw new BusinessException("无此产品");
        }
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

        $product = $result->data;
        if ($product && $product->discount)
        {
            $product->discount->discountTime = FctCommon::secondToString($product->discount->discountTime);
        }
        $member = Member::getAuth();
        $chatDatas = [
            "name" => $member ? $member->userName : "",
            "tel" => $member ? $member->cellPhone : "",
            "comment" => $product->name . '--' . url('product/' . $product->id) . '"}',
        ];
        return [
            'title' => (isset($product->name) && $product->name ? $product->name : '产品详情') . '方寸堂',
            'categories' => ProductCategory::getCategories(),
            'product' => $product,
            'chat_url' => 'https://static.meiqia.com/dist/standalone.html?_=t&eid=62925&clientid='
                . ($member ?$member->memberId : "")
                . '&metadata=' .urlencode(json_encode($chatDatas, JSON_UNESCAPED_UNICODE)),
        ];
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

    /**获取分享的产品
     * @param $categoryCode
     * @param $name
     * @param $page
     * @return mixed
     * @throws BusinessException
     */
    public static function getShareProducts($categoryCode, $name, $page)
    {
        $pageIndex = $page < 1 ? 1 : $page;
        $pageSize = 20;

        $result = Base::http(
            env('API_URL') . self::$resourceUrl,
            [
                'name' => $name,
                'category_code' => $categoryCode,
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

        return $result->data;
    }
}