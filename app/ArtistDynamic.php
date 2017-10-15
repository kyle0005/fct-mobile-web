<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-10
 * Time: 下午2:13
 */

namespace App;


use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Cache;

class ArtistDynamic
{
    public static function getDynamics($artistId, $pageIndex = 1)
    {
        $cacheKey = 'artist_'.$artistId.'_comments_' . $pageIndex;
        $cacheTime = 3;
        $cacheResult = false;

        if (Cache::has($cacheKey))
        {
            $cacheResult = Cache::get($cacheKey);
        }

        if (!$cacheResult) {
            $pageSize = 20;
            $result = Base::http(
                env('API_URL') . sprintf('/artists/%d/dynamics', $artistId),
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

            $pagination = Base::pagination($result->data, $pageIndex, $pageSize);
            $cacheResult = $pagination;
            Cache::put($cacheKey, $cacheResult, $cacheTime);
        }

        return $cacheResult;
    }

}