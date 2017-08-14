<?php

namespace App;

use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Cache;

/**收藏夹
 * Class Favorite
 * @package App
 */
class Favorite
{
    public static function getFavorites($fromType)
    {
        $member = Member::getAuth();
        $pageIndex = 1;
        $cacheKey = 'php_'.$member->memberId.'_favorites_'.$fromType.'_' . $pageIndex;
        $cacheTime = 30;
        $cacheResult = false;

        if (Cache::has($cacheKey))
        {
            $cacheResult = Cache::get($cacheKey);
        }

        if (!$cacheResult) {

            $pageSize = 50;
            $result = Base::http(
                env('API_URL') . '/member/favorites',
                [
                    'from_type' => $fromType,
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

            if ($result->data)
            {
                $result->data = $result->data->elements;
            }
            $cacheResult = $result->data;

            Cache::put($cacheKey, $cacheResult, $cacheTime);
        }

        return $cacheResult;
    }

    public static function saveFavorite($fromType, $fromId)
    {
        $result = Base::http(
            env('API_URL') . '/member/favorites',
            [
                'from_id' => $fromId,
                'from_type' => $fromType,
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()]
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return $result;

    }
}
