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

            $pagination = Base::pagination($result->data, $pageIndex, $pageSize);

            $cacheResult = $pagination;
            Cache::put($cacheKey, $cacheResult, $cacheTime);
        }

        return $cacheResult;
    }

    public static function getArticle($id, $current)
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
            $resp = self::getPrevAndNextId($id, $current);
            $cacheResult->prevId = $resp->prevId;
            $cacheResult->nextId = $resp->nextId;
            Cache::put($cacheKey, $cacheResult, $cacheTime);
        }

        return $cacheResult;
    }

    public static function getPrevAndNextId($id, $current)
    {
        $response = (object)[
            'prevId' => 0,
            'nextId' => 0,
        ];

        $pagination = self::getArticles($current);
        $entries = $pagination->entries;
        if ($entries) {
            $temp = false;
            $hasCurrent = false;
            foreach ($entries as $key => $article) {

                //获取nextId
                if ($hasCurrent && $article->urlType) {

                    $response->nextId = $article->id;
                    break;
                }

                if ($article->id == $id) {
                    //判断是否有前面的id
                    if ($temp)
                        $response->prevId = $temp->id;
                    //当前id已经出现了
                    $hasCurrent = true;
                }

                //过滤外链的页面
                if ($article->urlType)
                    $temp = $article;
            }

            if ($response->nextId < 1 && $current < $pagination->pager->next) {
                $nextId = self::iterationNextId($current);
                if ($nextId)
                    $response->nextId = $nextId;
            }
        }

        return $response;
    }

    public static function iterationNextId($page) {

        $current = $page + 1;
        $pagination = self::getArticles($current);
        if ($pagination->entries) {
            foreach ($pagination->entries as $entry) {
                if ($entry->urlType)
                    return $entry->id;
            }

            if ($current < $pagination->pager->next)
                return self::iterationNextId($current);
        }
    }
}