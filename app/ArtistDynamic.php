<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-10
 * Time: 下午2:13
 */

namespace App;


use App\Exceptions\BusinessException;

class ArtistDynamic
{
    public static function getDynamics($artistId, $pageIndex = 1)
    {
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

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        $pagination = Base::pagination($result->data, $pageSize);
        return $pagination;
    }

}