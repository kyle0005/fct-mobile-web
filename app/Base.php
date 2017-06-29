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
        $method = strtoupper($method) == 'POST' ? 'POST' : 'GET';
        if ($method == 'GET' && $formParams)
        {
            $url = $url . '?' . http_build_query($formParams);
        }elseif ($formParams) {
            $options['form_params'] = $formParams;
        }

        if ($headers) {
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
            $result = \GuzzleHttp\json_decode($result->getBody()->getContents());
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

    public static function listByFields($items, $fields = [], $replaceFileds = [])
    {
        if (!$items)
            return [];
        $entries = [];
        foreach ($items as $item)
        {
            $entry = (object) [];
            foreach ($fields as $field)
            {
                if (isset($item->$field))
                {
                    if ($replaceFileds && isset($replaceFileds[$field]) && $replaceFileds[$field])
                    {
                        $entry->$replaceFileds[$field] = $item->$field;
                    }
                    else
                    {
                        $entry->$field = $item->$field;
                    }
                }
            }

            $entries[] = $entry;
        }

        return $entries;
    }


    public static function pagination($result, $pageSize = 20, $fields = [])
    {
        if ($result && $result->totalCount > 0)
        {
            if ($fields)
            {
                $items = self::listByFields($result->elements, $fields);
            }
            else
            {
                $items = $result->elements;
            }

            $totalPage = ceil($result->totalCount / $pageSize);

            $pager = (object) [
                'prev' => 0,
                'current' => $result->current,
                'next' => 0,
                'page_size' => $pageSize,
                'total_page' => $totalPage,
                'total' => $result->totalCount,
            ];
            if (($result->current - 1) > 0 && ($result->current - 1 <= $totalPage) && $totalPage > 1)
                $pager->prev = $result->current - 1;
            if ($result->current + 1 <= $totalPage)
                $pager->next = $result->current + 1;

            return (object) [
                'entries' => $items,
                'pager' => $pager
            ];
        }

        return [];
    }

}