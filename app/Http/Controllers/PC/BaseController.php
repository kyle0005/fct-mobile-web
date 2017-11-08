<?php

/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-14
 * Time: 上午9:24
 */

namespace App\Http\Controllers\PC;



use App\Http\Controllers\Controller;


class BaseController extends Controller
{
    public function __construct()
    {
        if (is_mobile()) {
            header('location:' . env('APP_URL'));
            exit();
        }
    }

    /**成功ajax返回内容
     * @param $message
     * @param null $url
     * @param null $extras
     * @return string
     */
    protected function returnAjaxSuccess($message, $url = null, $extras = null)
    {
        return json_encode([
            'code' => 200,
            'message' => $message,
            'url' => $url,
            'data' => $extras,
        ], JSON_UNESCAPED_UNICODE);
    }

    /**失败ajax返回内容
     * @param $message
     * @param null $url
     * @param null $extras
     * @return string
     */
    protected function returnAjaxError($message, $url = null, $extras = null)
    {
        return json_encode([
            'code' => 404,
            'message' => $message,
            'url' => $url,
            'data' => $extras,
        ], JSON_UNESCAPED_UNICODE);
    }

    /**自动判断是AJAX还是post
     * @param $message
     * @param null $url
     * @param null $extras
     * @return string
     */
    protected function autoReturn($message, $code = 404, $url = null, $extras = null)
    {
        if (request()->ajax()) {
            return json_encode([
                'code' => $code,
                'message' => $message,
                'url' => $url,
                'data' => $extras,
            ], JSON_UNESCAPED_UNICODE);
        }

        if ($code != 200)
        {
            $errorUrl = url('error', [], env('APP_SECURE')) . '?message=' . $message;
            if ($url)
                $errorUrl .= '&' . env('REDIRECT_KEY') . '=' . $url;

            return redirect($errorUrl);
        }

        return redirect($url ? $url : '');
    }

}