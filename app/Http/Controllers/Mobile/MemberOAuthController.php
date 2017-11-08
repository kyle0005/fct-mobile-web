<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-7-14
 * Time: 上午11:45
 */

namespace App\Http\Controllers\Mobile;


use App\Exceptions\BusinessException;
use App\FctCommon;
use App\FctValidator;
use App\MemberOAuth;
use Illuminate\Http\Request;

class MemberOAuthController extends BaseController
{

    public function index(Request $request) {

        try
        {
            $result = MemberOAuth::getURL();
            $this->cacheRedirectSourceUrl($request->server('HTTP_REFERER'));
            
            return redirect($result);
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn($e->getMessage(), $e->getCode());
        }
    }

    public function callback(Request $request)
    {

        $code = $request->get('code', '');

        if (!$code)
            return $this->autoReturn("授权失败", 404, $this->getRedirectSourceUrl());

        try
        {
            MemberOAuth::saveOAuth($code);
            return $this->autoReturn("授权成功", 200, $this->getRedirectSourceUrl());
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn("授权失败", 404, $this->getRedirectSourceUrl());
        }
    }

    public function bind(Request $request)
    {

        $openid = $request->get('openid', '');
        $cellphone = $request->get('cellphone', '');
        $captcha = $request->get('captcha', '');

        FctValidator::hasMobileCaptcha($captcha);
        $sessionId = FctCommon::getMobileSessionId();

        try
        {
            MemberOAuth::bindOAuth($openid,$cellphone, $captcha, $sessionId, $request->ip());
            return $this->autoReturn("授权成功", 200, $this->getRedirectSourceUrl());
        }
        catch (BusinessException $e)
        {
            return $this->autoReturn("授权失败", 404, $this->getRedirectSourceUrl());
        }
    }

}