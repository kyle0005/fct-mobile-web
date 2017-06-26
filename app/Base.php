<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-6-22
 * Time: 下午3:29
 */

namespace App;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;

class Base
{
    public static function http($url, $formParams = [], $headers = [], $method = "POST")
    {
        $options = [];
        if ($formParams)
        {
            $options['form_params'] = $formParams;
        }
        if ($headers)
        {
            $options['headers'] = $headers;
        }

        $client = new Client();
        try
        {
            $result = $client->request($method, $url, $options);
        }
        catch (\Exception $e)
        {
            throw new ServerException($e->getMessage());
        }

        $result = \GuzzleHttp\json_decode($result);
        if ($result) {
            return $result;
        }
        return (object) [
            'message' => '系统异常，请联系管理员',
            'code' => 500,
            'data' => [],
        ];

    }

    public static function sendCaptcha($cellphone, $sessionId, $ip, $action)
    {
        $result = Base::http(
            env('API_URL') . '/sms/send-captcha',
            [
                'session_id' => $sessionId,
                'cellphone' => $cellphone,
                'ip' => $ip,
                'action' => $action,
            ]
        );
        return $result;
    }

}