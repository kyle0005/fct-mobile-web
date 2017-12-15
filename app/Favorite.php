<?php

namespace App;

use App\Exceptions\BusinessException;

/**收藏夹
 * Class Favorite
 * @package App
 */
class Favorite
{
    public static function getFavorites($fromType)
    {
        $pageIndex = 1;
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
            throw new BusinessException($result->msg, $result->code);
        }

        if ($result->data)
        {
            $result->data = $result->data->elements;
        }
        $cacheResult = $result->data ? $result->data : [];

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
            throw new BusinessException($result->msg, $result->code);
        }

        return $result;

    }
}
