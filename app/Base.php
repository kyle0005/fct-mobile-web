<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-6-22
 * Time: 下午3:29
 */

namespace App;

use App\Exceptions\BusinessException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;

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

        try
        {
            $client = new Client();
            $result = $client->request($method, $url, $options);
        }
        catch (BadResponseException $e)
        {
            throw new BusinessException('系统异常，请联系管理员');
        }
        catch (ClientException $e)
        {
            throw new BusinessException('系统异常，请联系管理员');
        }

        if ($result->getStatusCode() == 200) {
            $result = \GuzzleHttp\json_decode($result->getBody());
            if ($result) {
                return $result;
            }
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