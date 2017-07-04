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
    public static function getProduct($id)
    {
        $id = intval($id);
        if (!$id)
        {
            throw new BusinessException("无此产品");
        }
        $result = Base::http(
            env('API_URL') . sprintf('/products/%d', $id),
            [],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        $product = $result->data;
        $member = Member::getAuth();
        $chatDatas = [
            "name" => $member->userName,
            "tel" => $member->cellPhone,
            "comment" => $product->name . '--' . url('product/' . $product->id) . '"}',
        ];
        return [
            'title' => (isset($product->name) && $product->name ? $product->name : '产品详情') . '方寸堂',
            'categories' => ProductCategory::getCategories(),
            'product' => $product,
            'chat_url' => 'https://static.meiqia.com/dist/standalone.html?_=t&eid=62925&clientid=' . $member->memberId
                . '&metadata=' .urlencode(json_encode($chatDatas, JSON_UNESCAPED_UNICODE)),
        ];
    }
}