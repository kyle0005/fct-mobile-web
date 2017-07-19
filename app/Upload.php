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

        if (!$action)
        {
            throw new BusinessException("上传的类型不存在");
        }
        if (!self::uploadAction($action))
        {
            throw new BusinessException("上传的类型不存在");
        }

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

    public static function uploadAction($action)
    {
        switch ($action)
        {
            case "idcard":
                return "身份证";
                break;

            case "head":
                return "头像";
                break;

            default:
                return "";
                break;
        }
    }
}