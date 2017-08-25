<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-11
 * Time: 下午3:11
 */

namespace App;


use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Cache;

class Wiki
{

    public static function getHome()
    {

        $cacheKey = 'wiki';
        $cacheTime = 30;
        $cacheResult = false;

        if (Cache::has($cacheKey)) {
            $cacheResult = Cache::get($cacheKey);
        }

        if (!$cacheResult) {

            $result = Base::http(
                env('API_URL') . '/wiki',
                [],
                [],
                'GET'
            );

            if ($result->code != 200) {
                throw new BusinessException($result->msg);
            }

            $cacheResult = (object) [
                'wikiCategories' => $result->data->categoryList ? $result->data->categoryList : [],
                'materials' => $result->data->materialList ? $result->data->materialList : [],
                'articles' =>  $result->data->articleList ? $result->data->articleList : [],
            ];
            Cache::put($cacheKey, $cacheResult, $cacheTime);
        }

        return $cacheResult;
    }

    public static function getItem($typeId, $type)
    {
        $allowTypes = ['category', 'material','article'];
        if (!in_array($type, $allowTypes)) {
            throw new BusinessException("请求的类型不存在");
        }
        if ($typeId < 1) {
            throw new BusinessException("请求的类型不存在");
        }

        //泥料与产品详情共享数据
        if ($type == 'material')
            return ProductMaterial::getMaterialAndProducts($typeId);

        $cacheKey = 'wiki_' . $type . '_' . $typeId;
        $cacheTime = 30;
        $cacheResult = false;

        if (Cache::has($cacheKey)) {
            $cacheResult = Cache::get($cacheKey);
        }

        if (!$cacheResult) {
            $result = Base::http(
                env('API_URL') . '/wiki/item',
                [
                    'type_id' => $typeId,
                    'type' => $type,
                ],
                [],
                'GET'
            );

            if ($result->code != 200) {
                throw new BusinessException($result->msg);
            }

            /*return ;*/
            $cacheResult = $result->data;
            Cache::put($cacheKey, $cacheResult, $cacheTime);
        }

        return $cacheResult;
    }

    public static function getFromTypes($type, $id)
    {
        $result = self::getHome();
        if (!$result)
        {
            return [];
        }

        $resultList = [];
        switch ($type)
        {
            case 'category':
                foreach ($result->wikiCategories as $category)
                {
                    foreach ($category->subList as $subCategory)
                    {
                        if ($subCategory->id == $id)
                        {
                            $resultList = $category->subList;
                            break;
                        }
                    }
                    if ($resultList)
                        break;
                }
                break;
            case 'material':
                $resultList = $result->materials;
                break;
            case 'article':
                $resultList = $result->articles;
                break;
        }

        return $resultList;
    }
}