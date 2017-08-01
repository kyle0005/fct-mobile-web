<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-11
 * Time: 下午3:11
 */

namespace App;


use App\Exceptions\BusinessException;

class Wiki
{

    public static function getHome() {

        $result = Base::http(
            env('API_URL') . '/wiki',
            [],
            [],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return [
            'title' => '紫砂百科 - 方寸网',
            'categories' => ProductCategory::getCategories(),
            'wikiCategories' => $result->data->categoryList,
            'materials' => $result->data->materialList,
        ];
    }

    public static function getItem($typeId, $type)
    {
        $allowTypes = ['category', 'material'];
        if (!in_array($type, $allowTypes))
        {
            throw new BusinessException("请求的类型不存在");
        }
        if ($typeId < 1)
        {
            throw new BusinessException("请求的类型不存在");
        }

        $result = Base::http(
            env('API_URL') . '/wiki/item',
            [
                'type_id' => $typeId,
                'type' => $type,
            ],
            [],
            'GET'
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return [
            'title' => '紫砂百科 - 方寸网',
            'categories' => ProductCategory::getCategories(),
            'entry' => $result->data,
        ];
    }
}