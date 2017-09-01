<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-8-29
 * Time: 下午3:51
 */

namespace App;


use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Cache;

class Article
{
    public static $resourceUrl = '/mall/articles';

    public static function getArticles($pageIndex)
    {
        $cacheKey = 'articles_' . $pageIndex;
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
                    'code' => ',3,',
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

    public static function getArticle($id)
    {
        $cacheKey = 'article_' . $id;
        $cacheTime = 30;
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
            $cacheResult = $result->data;
            Cache::put($cacheKey, $cacheResult, $cacheTime);
        }

        return $cacheResult;
    }
}