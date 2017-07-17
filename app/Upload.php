<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-17
 * Time: 上午10:57
 */

namespace App;


use App\Exceptions\BusinessException;

class Upload
{
    public static $resourceUrl = '/upload';

    public static function uploadImage($action, $file)
    {

        $result = Base::http(
            env('API_URL') . sprintf('%s/image', self::$resourceUrl),
            [
                'action' => $action,
                'file' => [
                    'name' => 'file',
                    'contents' => fopen($file->getRealPath(), 'r'),
                    'filename' => $file->getClientOriginalName()
                ],
            ],
            [env('MEMBER_TOKEN_NAME') => Member::getToken()],
            'POST',
            true
        );

        if ($result->code != 200)
        {
            throw new BusinessException($result->msg);
        }

        return $result;
    }
}