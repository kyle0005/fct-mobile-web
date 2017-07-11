<?php

namespace App;

use App\Exceptions\BusinessException;

/**收藏夹
 * Class Favorite
 * @package App
 */
class Favorite
{
    public static function getFavorites($fromType) {

    }

    public static function saveFavorite($fromType, $fromId)
    {
        $result = Base::http(
            env('API_URL') . '/favorites',
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
