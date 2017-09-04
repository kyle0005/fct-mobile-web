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
            foreach ($entries as $key => $article) {
                if ($article->id == $id && $temp) {
                    $response->prevId = $temp->id;
                    $article = isset($entries[$key + 1]) ? $entries[$key + 1] : false;
                    if ($article) {
                        $response->nextId = $article->id;
                    } elseif ($current + 1 == $pagination->pager->next) {
                        //重新获取下一页
                        $pagination = self::getArticles($current + 1);
                        if ($pagination->entries)
                            $response->nextId = $pagination->entries[0]->id;
                    }

                    break;
                }
                $temp = $article;
            }
        }

        return $response;
    }
}