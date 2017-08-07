<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-10
 * Time: 下午2:00
 */

namespace App;


use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Cache;

class ArtistComment
{
    public static function getComments($artistId, $pageIndex = 1)
    {
        $cacheKey = 'php_artist_'.$artistId.'_comments_' . $pageIndex;
        $cacheTime = 10;
        $cacheResult = false;

        if (Cache::has($cacheKey))
        {
            $cacheResult = Cache::get($cacheKey);
        }

        if (!$cacheResult) {
            $pageSize = 20;
            $result = Base::http(
                env('API_URL') . sprintf('/artists/%d/comments', $artistId),
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

    public static function saveComment($artistId, $content) {

        $result = Base::http(
            env('API_URL') . sprintf('/artists/%d/comments', $artistId),
            [
                'artist_id' => $artistId,
                'content' => $content,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return true;
    }
}